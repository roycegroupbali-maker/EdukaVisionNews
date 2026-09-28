<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleLikeController extends Controller
{
    /** Nama cookie penanda pengunjung anonim, dipakai supaya 1 pengunjung ≈ 1 suara. */
    private const VISITOR_COOKIE = 'evn_visitor';

    /** Umur cookie pengunjung: 2 tahun (dalam menit), dipakai barengan lewat Http\Middleware\EncryptCookies bawaan Laravel. */
    private const VISITOR_COOKIE_MINUTES = 60 * 24 * 365 * 2;

    /**
     * Like/unlike berita (toggle). Fitur ini TENTATIVE — dikontrol lewat
     * config('features.likes_enabled') supaya bisa dimatikan sewaktu-waktu
     * tanpa perlu ubah/deploy ulang kode (cukup ubah .env).
     *
     * Anti-spam / anti-klik-berulang:
     * - Setiap pengunjung diberi ID anonim lewat cookie tahan-lama (bukan
     *   akun), lalu kombinasi article_id + visitor_id diberi constraint
     *   UNIQUE di database (lihat migration article_likes) — jadi walau
     *   tombol diklik berkali-kali atau request dikirim paralel, like yang
     *   benar-benar tercatat tetap hanya satu per pengunjung per berita.
     * - Route ini juga dibatasi throttle (lihat routes/web.php) sebagai
     *   lapisan tambahan terhadap request bertubi-tubi dari script/bot.
     */
    public function toggle(Request $request, Article $article): JsonResponse
    {
        abort_unless(config('features.likes_enabled'), 404);

        $visitorId = (string) ($request->cookie(self::VISITOR_COOKIE) ?: Str::uuid());

        $existing = ArticleLike::where('article_id', $article->id)
            ->where('visitor_id', $visitorId)
            ->first();

        if ($existing) {
            $existing->delete();
            $article->decrement('likes');
            $liked = false;
        } else {
            try {
                ArticleLike::create([
                    'article_id' => $article->id,
                    'visitor_id' => $visitorId,
                    'ip_address' => $request->ip(),
                ]);
                $article->increment('likes');
            } catch (QueryException $e) {
                // Race condition: dua request nyaris bersamaan dari pengunjung
                // yang sama sudah lebih dulu membuat baris like ini — anggap
                // saja statusnya sudah "liked", jangan tambah counter lagi.
            }
            $liked = true;
        }

        return response()
            ->json([
                'ok' => true,
                'liked' => $liked,
                'likes' => $article->fresh()->likes,
            ])
            ->cookie(self::VISITOR_COOKIE, $visitorId, self::VISITOR_COOKIE_MINUTES);
    }
}

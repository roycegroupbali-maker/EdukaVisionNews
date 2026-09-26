<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleStat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArticleShareController extends Controller
{
    private const NETWORKS = ['whatsapp', 'facebook', 'x'];

    /**
     * Hitung share lalu teruskan pembaca ke jaringan sosial yang dipilih.
     */
    public function redirect(Request $request, Article $article, string $platform): RedirectResponse
    {
        abort_unless(in_array($platform, self::NETWORKS, true), 404);

        $article->increment('shares');
        ArticleStat::hit($article->id, 'shares');

        $url = route('article.show', $article->slug);
        $title = $article->title;

        $target = match ($platform) {
            'whatsapp' => 'https://wa.me/?text='.rawurlencode($title.' '.$url),
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($url),
            'x' => 'https://twitter.com/intent/tweet?text='.rawurlencode($title).'&url='.rawurlencode($url),
        };

        return redirect()->away($target);
    }

    /**
     * Dipanggil lewat AJAX saat pembaca menekan tombol "Salin Tautan",
     * supaya jumlah share tetap tercatat tanpa perlu reload/redirect.
     */
    public function copy(Article $article): JsonResponse
    {
        $article->increment('shares');
        ArticleStat::hit($article->id, 'shares');

        return response()->json([
            'ok' => true,
            'shares' => $article->fresh()->shares,
            'url' => route('article.show', $article->slug),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar baru dari pembaca. Komentar SELALU masuk berstatus
     * "pending" dulu — baru tampil publik setelah disetujui admin/editor
     * lewat panel moderasi (Admin\CommentController).
     *
     * Proteksi spam & input berbahaya (defense in depth, beberapa lapis):
     * 1. Honeypot ("website"): field tersembunyi lewat CSS yang hanya
     *    diisi bot pengisi form otomatis; kalau terisi, komentar dibuang
     *    diam-diam (tanpa error, supaya bot tidak belajar mem-bypassnya).
     * 2. Validasi ketat panjang nama & isi komentar.
     * 3. strip_tags() saat disimpan -> TIDAK ADA HTML/JS sama sekali yang
     *    tersimpan di database.
     * 4. Saat ditampilkan, tetap dirender lewat {{ }} (auto-escape Blade),
     *    bukan {!! !!} -> lapis pertahanan kedua terhadap XSS.
     * 5. Rate limit per IP lewat middleware throttle di routes/web.php.
     */
    public function store(Request $request, Article $article): RedirectResponse
    {
        abort_unless(config('features.comments_enabled') && $article->comments_enabled, 404);

        if ($request->filled('website')) {
            // Honeypot terisi -> anggap bot. Pura-pura sukses supaya bot
            // tidak tahu kalau terdeteksi.
            return redirect(route('article.show', $article->slug).'#komentar')
                ->with('status', 'Terima kasih! Komentar kamu terkirim dan akan tampil setelah disetujui moderator.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'body.required' => 'Komentar tidak boleh kosong.',
            'body.min' => 'Komentar terlalu pendek.',
            'body.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'name' => strip_tags($data['name']),
            'body' => strip_tags($data['body']),
            'status' => Comment::STATUS_PENDING,
            'ip_address' => $request->ip(),
        ]);

        return redirect(route('article.show', $article->slug).'#komentar')
            ->with('status', 'Terima kasih! Komentar kamu terkirim dan akan tampil setelah disetujui moderator.');
    }
}

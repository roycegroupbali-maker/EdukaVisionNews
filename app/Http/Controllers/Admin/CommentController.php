<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $comments = Comment::with('article')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->get('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', "%{$term}%")->orWhere('body', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $pendingCount = Comment::status(Comment::STATUS_PENDING)->count();

        return view('admin.comments.index', compact('comments', 'pendingCount'));
    }

    /**
     * Setujui komentar -> langsung tampil di halaman berita publik.
     */
    public function approve(Request $request, Comment $comment): RedirectResponse
    {
        $comment->update([
            'status' => Comment::STATUS_APPROVED,
            'moderated_by' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        return back()->with('status', 'Komentar disetujui & tayang di halaman berita.');
    }

    /**
     * Sembunyikan komentar (bukan dihapus permanen) — dipakai untuk komentar
     * yang tidak pantas tapi ingin tetap disimpan sebagai jejak moderasi.
     */
    public function hide(Request $request, Comment $comment): RedirectResponse
    {
        $comment->update([
            'status' => Comment::STATUS_HIDDEN,
            'moderated_by' => $request->user()->id,
            'moderated_at' => now(),
        ]);

        return back()->with('status', 'Komentar disembunyikan dari halaman berita.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}

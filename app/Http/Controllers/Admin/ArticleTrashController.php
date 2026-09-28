<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Tempat Sampah Berita. Berita yang dihapus editor/wartawan hanya di-soft-delete:
 * hilang dari web, tetapi tetap tersimpan di sini sebagai cadangan. Hanya
 * Super Admin yang bisa melihat, memulihkan, atau menghapus permanen.
 */
class ArticleTrashController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        $articles = Article::onlyTrashed()
            ->with(['category', 'authorUser', 'deletedByUser'])
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->get('q').'%'))
            ->latest('deleted_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.trash.index', compact('articles'));
    }

    public function restore(Request $request): RedirectResponse
    {
        $this->authorizeSuperAdmin($request);
        $ids = $this->validatedIds($request);

        $items = Article::onlyTrashed()->whereIn('id', $ids)->get();

        foreach ($items as $article) {
            $article->deleted_by = null;
            $article->restore();
        }

        return back()->with('status', "{$items->count()} berita berhasil dipulihkan.");
    }

    public function forceDelete(Request $request): RedirectResponse
    {
        $this->authorizeSuperAdmin($request);
        $ids = $this->validatedIds($request);

        $items = Article::onlyTrashed()->whereIn('id', $ids)->get();

        foreach ($items as $article) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }

            $article->forceDelete();
        }

        return back()->with('status', "{$items->count()} berita dihapus permanen.");
    }

    private function authorizeSuperAdmin(Request $request): void
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Super Admin yang dapat mengakses Tempat Sampah.');
    }

    /** @return array<int, int> */
    private function validatedIds(Request $request): array
    {
        return $request->validate([
            'ids' => ['required', 'array', 'min:1', 'max:100'],
            'ids.*' => ['integer'],
        ], [
            'ids.required' => 'Pilih minimal satu berita.',
            'ids.min' => 'Pilih minimal satu berita.',
        ])['ids'];
    }
}

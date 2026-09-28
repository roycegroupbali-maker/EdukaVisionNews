<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private const PATTERNS = ['wave', 'circles', 'triangle', 'grid', 'dots', 'arrow'];

    public function index(Request $request): View
    {
        $user = $request->user();
        $categories = Category::orderBy('sort_order')->get();

        $articles = Article::with(['category', 'authorUser', 'editor'])
            // Wartawan (tanpa izin articles.view_all) hanya melihat berita miliknya
            // sendiri — sesuai alur: mereka menulis & mengajukan, bukan mengelola
            // punya orang lain.
            ->when(! $user->hasPermission('articles.view_all'), fn ($q) => $q->where('author_id', $user->id))
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->get('category'))))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->get('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")->orWhere('excerpt', 'like', "%{$term}%");
                });
            })
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $pendingCount = $user->hasPermission('articles.publish')
            ? Article::status(Article::STATUS_PENDING)->count()
            : 0;

        return view('admin.articles.index', compact('articles', 'categories', 'pendingCount'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->hasPermission('articles.create'), 403, 'Jabatan Anda tidak memiliki izin menulis berita.');

        $categories = Category::orderBy('sort_order')->get();
        $article = new Article(['art_color1' => '#14213D', 'art_color2' => '#2a3f75', 'art_pattern' => 'wave']);

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'patterns' => self::PATTERNS,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->hasPermission('articles.create'), 403, 'Jabatan Anda tidak memiliki izin menulis berita.');

        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $request->input('slug'));
        $data['author_id'] = $user->id;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $data = $this->applyWorkflow($request, $data, $user);

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', $this->storeStatusMessage($data['status']));
    }

    public function edit(Request $request, Article $article): View
    {
        $this->authorizeManage($request, $article);

        $categories = Category::orderBy('sort_order')->get();

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'patterns' => self::PATTERNS,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $user = $request->user();
        $this->authorizeManage($request, $article);

        $data = $this->validated($request, $article);

        if ($request->input('slug') !== $article->slug || $data['title'] !== $article->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $request->input('slug'), $article->id);
        } else {
            $data['slug'] = $article->slug;
        }

        if ($request->hasFile('image')) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        } elseif ($request->boolean('remove_image') && $article->image_path) {
            Storage::disk('public')->delete($article->image_path);
            $data['image_path'] = null;
        }

        $data = $this->applyWorkflow($request, $data, $user, $article);

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', $this->storeStatusMessage($data['status'], true));
    }

    public function destroy(Request $request, Article $article): RedirectResponse
    {
        $user = $request->user();

        $canDeleteOwn = $article->author_id === $user->id
            && in_array($article->status, [Article::STATUS_DRAFT, Article::STATUS_REVISION], true);

        abort_unless($user->hasPermission('articles.delete') || $canDeleteOwn, 403, 'Anda tidak memiliki izin menghapus berita ini.');

        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();

        return back()->with('status', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle cepat status featured langsung dari daftar berita. Hanya
     * berlaku untuk pemegang izin publish karena "headline" muncul di
     * halaman utama publik, jadi harus lewat orang yang berwenang tayang.
     */
    public function toggleFeatured(Request $request, Article $article): RedirectResponse
    {
        abort_unless($request->user()->hasPermission('articles.publish'), 403);

        $article->update(['is_featured' => ! $article->is_featured]);

        return back()->with('status', $article->is_featured ? 'Berita dijadikan headline.' : 'Berita dilepas dari headline.');
    }

    /**
     * Editor/admin menyetujui (ACC) berita yang diajukan wartawan. Berita
     * langsung tayang ke publik saat ini (kecuali sudah dijadwalkan lebih
     * lambat lewat kolom "Jadwal Tayang" sebelumnya).
     */
    public function approve(Request $request, Article $article): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->hasPermission('articles.publish'), 403, 'Anda tidak memiliki izin menyetujui berita.');

        abort_unless(
            in_array($article->status, [Article::STATUS_PENDING, Article::STATUS_REVISION], true),
            422,
            'Hanya berita berstatus "Menunggu Tinjauan" atau "Perlu Revisi" yang bisa disetujui.'
        );

        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'published_at' => $article->published_at && $article->published_at->isFuture() ? $article->published_at : now(),
            'editor_id' => $user->id,
            'reviewed_at' => now(),
            'review_note' => null,
        ]);

        return back()->with('status', "Berita \"{$article->title}\" disetujui & dipublikasikan.");
    }

    /**
     * Editor/admin menolak/mengembalikan berita untuk direvisi wartawan.
     * Catatan revisi wajib diisi supaya wartawan tahu apa yang perlu
     * diperbaiki.
     */
    public function reject(Request $request, Article $article): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->hasPermission('articles.publish'), 403, 'Anda tidak memiliki izin menolak berita.');

        abort_unless(
            in_array($article->status, [Article::STATUS_PENDING, Article::STATUS_REVISION], true),
            422,
            'Hanya berita berstatus "Menunggu Tinjauan" atau "Perlu Revisi" yang bisa dikembalikan.'
        );

        $data = $request->validate([
            'review_note' => ['required', 'string', 'max:1000'],
        ], [
            'review_note.required' => 'Catatan revisi wajib diisi supaya wartawan tahu apa yang perlu diperbaiki.',
        ]);

        $article->update([
            'status' => Article::STATUS_REVISION,
            'editor_id' => $user->id,
            'reviewed_at' => now(),
            'review_note' => $data['review_note'],
        ]);

        return back()->with('status', "Berita \"{$article->title}\" dikembalikan untuk direvisi.");
    }

    /**
     * Pastikan user boleh membuka form edit/update berita ini: pemegang izin
     * publish (editor/admin) bebas mengedit berita siapa pun; wartawan hanya
     * boleh mengedit berita miliknya sendiri, dan hanya selama belum
     * disetujui (draft/revisi/pending — bukan yang sudah tayang).
     */
    private function authorizeManage(Request $request, Article $article): void
    {
        $user = $request->user();

        if ($user->hasPermission('articles.publish')) {
            return;
        }

        abort_unless($article->author_id === $user->id, 403, 'Anda hanya bisa mengelola berita milik Anda sendiri.');

        abort_if(
            $article->status === Article::STATUS_PUBLISHED,
            403,
            'Berita yang sudah tayang tidak bisa diubah lagi. Hubungi editor jika perlu revisi.'
        );
    }

    /**
     * Tentukan status akhir berita berdasarkan hak akses pengguna & tombol
     * aksi yang ditekan di form (simpan draf / ajukan tinjauan / tayangkan).
     * Wartawan tanpa izin publish TIDAK PERNAH bisa langsung menayangkan
     * berita, apa pun input yang dikirim — inilah inti alur verifikasinya.
     */
    private function applyWorkflow(Request $request, array $data, $user, ?Article $article = null): array
    {
        $canPublish = $user->hasPermission('articles.publish');
        $action = $request->input('workflow_action', 'draft'); // draft | submit | publish

        if ($canPublish) {
            if ($action === 'publish' || $request->boolean('publish_now')) {
                $data['status'] = Article::STATUS_PUBLISHED;
                $data['published_at'] = $data['published_at'] ?? now();
                $data['editor_id'] = $user->id;
                $data['reviewed_at'] = now();
            } elseif (($data['published_at'] ?? null) !== null) {
                // Jadwal tayang diisi tanpa centang "tayangkan sekarang" — tetap
                // dianggap published (menunggu jadwal), sama seperti perilaku lama.
                $data['status'] = Article::STATUS_PUBLISHED;
                $data['editor_id'] = $user->id;
                $data['reviewed_at'] = now();
            } else {
                $data['status'] = Article::STATUS_DRAFT;
            }

            return $data;
        }

        // Wartawan / jabatan tanpa izin publish:
        unset($data['published_at']);

        if ($action === 'submit') {
            $data['status'] = Article::STATUS_PENDING;
            $data['submitted_at'] = now();
            $data['review_note'] = null; // ajuan baru mereset catatan revisi sebelumnya
        } else {
            // Simpan tanpa mengajukan ulang: status pengajuan yang sudah ada
            // (draft/pending/revisi) TIDAK berubah, supaya menyimpan draf kecil
            // di tengah proses tinjauan tidak diam-diam menghapus pengajuan.
            $data['status'] = $article?->status ?? Article::STATUS_DRAFT;
        }

        return $data;
    }

    private function storeStatusMessage(string $status, bool $isEdit = false): string
    {
        $verb = $isEdit ? 'diperbarui' : 'disimpan';

        return match ($status) {
            Article::STATUS_PUBLISHED => "Berita berhasil {$verb} & dipublikasikan.",
            Article::STATUS_PENDING => "Berita berhasil diajukan. Menunggu tinjauan editor.",
            Article::STATUS_REVISION => "Perubahan disimpan. Berita masih berstatus perlu revisi — ajukan ulang setelah selesai diperbaiki.",
            default => "Berita berhasil {$verb} sebagai draf.",
        };
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'subcategory' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:100'],
            'read_minutes' => ['nullable', 'integer', 'min:1', 'max:60'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'],
            'remove_image' => ['nullable', 'boolean'],
            'image_caption' => ['nullable', 'string', 'max:255'],
            'image_source' => ['nullable', 'string', 'max:150'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image_link' => ['nullable', 'url', 'max:500', 'regex:~^https?://~i'],
            'youtube_url' => ['nullable', 'url', 'max:255', 'regex:~^https?://((www|m|music)\.)?(youtube\.com|youtu\.be)/~i'],
            'tags' => ['nullable', 'string', 'max:500'],
            // Gambar generatif (warna & pola) tidak lagi diisi lewat form — kartunya
            // sudah dihapus karena berita memakai upload foto. Aturannya dibuat
            // 'sometimes' (bukan dihapus) supaya: berita lama tetap memakai nilai
            // yang sudah tersimpan, berita baru memakai default kolom database
            // (#14213D / #2a3f75 / wave), dan kalau suatu saat form-nya dikembalikan,
            // inputnya tetap divalidasi.
            'art_color1' => ['sometimes', 'nullable', 'string', 'max:20'],
            'art_color2' => ['sometimes', 'nullable', 'string', 'max:20'],
            'art_pattern' => ['sometimes', 'nullable', Rule::in(self::PATTERNS)],
            'recipe_minutes' => ['nullable', 'integer', 'min:1', 'max:600'],
            'recipe_servings' => ['nullable', 'integer', 'min:1', 'max:100'],
            'recipe_difficulty' => ['nullable', 'string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_sponsored' => ['nullable', 'boolean'],
            'comments_enabled' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'publish_now' => ['nullable', 'boolean'],
            'workflow_action' => ['nullable', 'string', Rule::in(['draft', 'submit', 'publish'])],
        ], [
            'youtube_url.url' => 'Format URL YouTube tidak valid.',
            'youtube_url.regex' => 'URL harus berasal dari youtube.com atau youtu.be.',
            'image_link.url' => 'Format tautan gambar tidak valid.',
            'image_link.regex' => 'Tautan harus diawali http:// atau https://.',
        ]);

        $data['author'] = $data['author'] ?? '' ?: 'Redaksi EdukaVisionNews';
        $data['read_minutes'] = $data['read_minutes'] ?? '' ?: 4;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_sponsored'] = $request->boolean('is_sponsored');
        $data['comments_enabled'] = $request->boolean('comments_enabled');

        // Jangan biarkan nilai kosong menimpa warna/pola yang sudah ada.
        foreach (['art_color1', 'art_color2', 'art_pattern'] as $artKey) {
            if (array_key_exists($artKey, $data) && ($data[$artKey] === null || $data[$artKey] === '')) {
                unset($data[$artKey]);
            }
        }

        unset($data['publish_now'], $data['image'], $data['remove_image'], $data['workflow_action']);

        return $data;
    }

    private function uniqueSlug(string $title, ?string $preferred, ?int $ignoreId = null): string
    {
        $base = Str::slug($preferred ?: $title);
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}

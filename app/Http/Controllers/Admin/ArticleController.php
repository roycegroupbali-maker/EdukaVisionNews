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
        $categories = Category::orderBy('sort_order')->get();

        $articles = Article::with('category')
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->get('category'))))
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->get('status') === 'published') {
                    $q->published();
                } elseif ($request->get('status') === 'draft') {
                    $q->where(function ($sub) {
                        $sub->whereNull('published_at')->orWhere('published_at', '>', now());
                    });
                }
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")->orWhere('excerpt', 'like', "%{$term}%");
                });
            })
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
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
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $request->input('slug'));

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Berita berhasil dipublikasikan/disimpan.');
    }

    public function edit(Article $article): View
    {
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

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Perubahan berita berhasil disimpan.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();

        return back()->with('status', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle cepat status featured langsung dari daftar berita.
     */
    public function toggleFeatured(Article $article): RedirectResponse
    {
        $article->update(['is_featured' => ! $article->is_featured]);

        return back()->with('status', $article->is_featured ? 'Berita dijadikan headline.' : 'Berita dilepas dari headline.');
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
            'art_color1' => ['required', 'string', 'max:20'],
            'art_color2' => ['required', 'string', 'max:20'],
            'art_pattern' => ['required', Rule::in(self::PATTERNS)],
            'recipe_minutes' => ['nullable', 'integer', 'min:1', 'max:600'],
            'recipe_servings' => ['nullable', 'integer', 'min:1', 'max:100'],
            'recipe_difficulty' => ['nullable', 'string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_sponsored' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'publish_now' => ['nullable', 'boolean'],
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

        if ($request->boolean('publish_now')) {
            $data['published_at'] = now();
        }

        unset($data['publish_now'], $data['image'], $data['remove_image']);

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
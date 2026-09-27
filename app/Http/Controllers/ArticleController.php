<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleStat;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Homepage: hero + per-category sections, pulled live from the database.
     */
    public function home(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        $hero = Article::published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->with('category')
            ->first()
            ?? Article::published()->with('category')->latest('published_at')->first();

        $sideList = Article::published()
            ->with('category')
            ->when($hero, fn ($q) => $q->where('id', '!=', $hero->id))
            ->latest('published_at')
            ->limit(4)
            ->get();

        $trending = Article::published()
            ->with('category')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $latest = Article::published()
            ->with('category')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // one block of articles per category for the homepage sections
        $sections = $categories->mapWithKeys(function (Category $category) {
            return [
                $category->slug => $category->publishedArticles()->with('category')->limit(8)->get(),
            ];
        });

        return view('home', compact('categories', 'hero', 'sideList', 'trending', 'latest', 'sections'));
    }

    /**
     * Category listing page, e.g. /kategori/olahraga
     */
    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->publishedArticles()
            ->with('category')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('sort_order')->get();

        return view('categories.show', compact('category', 'articles', 'categories'));
    }

    /**
     * Article detail page, e.g. /berita/judul-artikel
     */
    public function show(Article $article): View
    {
        abort_unless(
            $article->status === Article::STATUS_PUBLISHED && $article->published_at && $article->published_at->lte(now()),
            404
        );

        $article->increment('views');
        ArticleStat::hit($article->id, 'views');
        $article->load('category');

        $related = Article::published()
            ->with('category')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

        $categories = Category::orderBy('sort_order')->get();

        return view('articles.show', compact('article', 'related', 'categories'));
    }

    /**
     * Simple full-text-ish search across title, excerpt and content.
     */
    public function search(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));

        $articles = Article::published()
            ->with('category')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('sort_order')->get();

        return view('search', compact('articles', 'query', 'categories'));
    }
}

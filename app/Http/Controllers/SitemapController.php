<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap XML sederhana: beranda, semua kategori, dan semua artikel terbit.
     * Membantu Google/mesin pencari menemukan & mengindeks seluruh konten.
     */
    public function index(): Response
    {
        $categories = Category::orderBy('sort_order')->get();
        $articles = Article::published()->orderByDesc('published_at')->get(['slug', 'updated_at']);

        $urls = collect();

        $urls->push([
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'priority' => '1.0',
        ]);

        foreach ($categories as $category) {
            $urls->push([
                'loc' => route('category.show', $category->slug),
                'lastmod' => now()->toAtomString(),
                'priority' => '0.7',
            ]);
        }

        foreach ($articles as $article) {
            $urls->push([
                'loc' => route('article.show', $article->slug),
                'lastmod' => $article->updated_at?->toAtomString() ?? now()->toAtomString(),
                'priority' => '0.6',
            ]);
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}

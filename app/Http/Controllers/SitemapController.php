<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    /**
     * Sitemap XML: beranda, halaman statis, semua kategori, dan semua artikel
     * terbit (lengkap dengan gambar). Membantu Google/mesin pencari menemukan
     * & mengindeks seluruh konten secara efisien.
     */
    public function index(): Response
    {
        $categories = Category::orderBy('sort_order')->get();
        $articles = Article::published()
            ->orderByDesc('published_at')
            ->get(['slug', 'title', 'updated_at', 'category_id', 'image_path', 'image_alt']);

        $lastArticleUpdate = $articles->max('updated_at');

        $urls = collect();

        // Beranda: berubah setiap ada artikel baru, jadi changefreq tinggi.
        $urls->push([
            'loc' => route('home'),
            'lastmod' => ($lastArticleUpdate ?? now())->toAtomString(),
            'changefreq' => 'hourly',
            'priority' => '1.0',
        ]);

        // Halaman statis penting untuk kredibilitas media siber (E-E-A-T:
        // redaksi & pedoman menunjukkan situs punya penanggung jawab jelas).
        foreach ([
            ['route' => 'pages.about', 'priority' => '0.4'],
            ['route' => 'pages.redaksi', 'priority' => '0.4'],
            ['route' => 'pages.pedoman', 'priority' => '0.3'],
        ] as $page) {
            $urls->push([
                'loc' => route($page['route']),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => $page['priority'],
            ]);
        }

        foreach ($categories as $category) {
            $lastInCategory = $articles->where('category_id', $category->id)->max('updated_at');

            $urls->push([
                'loc' => route('category.show', $category->slug),
                'lastmod' => ($lastInCategory ?? $category->updated_at ?? now())->toAtomString(),
                'changefreq' => 'hourly',
                'priority' => '0.7',
            ]);
        }

        foreach ($articles as $article) {
            $urls->push([
                'loc' => route('article.show', $article->slug),
                'lastmod' => $article->updated_at?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.6',
                'image' => $article->image_path ? Storage::disk('public')->url($article->image_path) : null,
                'image_title' => $article->image_alt ?? $article->title,
            ]);
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}

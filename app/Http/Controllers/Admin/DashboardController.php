<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::published()->count();
        $draftArticles = $totalArticles - $publishedArticles;
        $totalAds = Ad::count();
        $activeAds = Ad::active()->count();

        $articlesPerCategory = Category::withCount('articles')
            ->orderBy('sort_order')
            ->get();

        $latestArticles = Article::with('category')
            ->latest('created_at')
            ->limit(6)
            ->get();

        $mostViewed = Article::with('category')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalArticles', 'publishedArticles', 'draftArticles',
            'totalAds', 'activeAds', 'articlesPerCategory',
            'latestArticles', 'mostViewed'
        ));
    }
}

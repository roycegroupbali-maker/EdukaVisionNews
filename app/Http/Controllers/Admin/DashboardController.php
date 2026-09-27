<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Category;
use App\Models\NewsSubmission;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::published()->count();
        $draftArticles = $totalArticles - $publishedArticles;
        $pendingReview = Article::status(Article::STATUS_PENDING)->count();
        $totalAds = Ad::count();
        $activeAds = Ad::active()->count();
        $pendingSubmissions = NewsSubmission::status(NewsSubmission::STATUS_PENDING)->count();

        $articlesPerCategory = Category::withCount('articles')
            ->withSum('articles', 'views')
            ->withSum('articles', 'shares')
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

        $mostShared = Article::with('category')
            ->orderByDesc('shares')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalArticles', 'publishedArticles', 'draftArticles', 'pendingReview',
            'totalAds', 'activeAds', 'pendingSubmissions', 'articlesPerCategory',
            'latestArticles', 'mostViewed', 'mostShared'
        ));
    }
}

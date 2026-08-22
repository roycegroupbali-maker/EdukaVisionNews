<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AdClickController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [ArticleController::class, 'home'])->name('home');
Route::get('/cari', [ArticleController::class, 'search'])->name('search');
Route::get('/kategori/{slug}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/berita/{article:slug}', [ArticleController::class, 'show'])->name('article.show');

// Tautan klik iklan publik — hitung klik lalu teruskan ke target_url pengiklan.
Route::get('/iklan/{ad}/klik', AdClickController::class)->name('ads.click');

/*
|--------------------------------------------------------------------------
| Panel Admin
|--------------------------------------------------------------------------
| Semua rute di bawah /admin. Login memakai guard session bawaan Laravel,
| lalu middleware "admin" memastikan hanya user dengan is_admin=true yang
| bisa masuk. Link masuk ke panel ini sengaja diletakkan kecil di footer.
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::patch('/articles/{article}/toggle-featured', [AdminArticleController::class, 'toggleFeatured'])
            ->name('articles.toggle-featured');

        Route::resource('categories', AdminCategoryController::class)->except(['show', 'create', 'edit']);

        Route::resource('ads', AdController::class)->except(['show']);
        Route::patch('/ads/{ad}/toggle-active', [AdController::class, 'toggleActive'])->name('ads.toggle-active');
    });
});

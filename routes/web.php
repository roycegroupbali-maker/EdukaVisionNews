<?php

use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsSubmissionController as AdminNewsSubmissionController;
use App\Http\Controllers\AdClickController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleShareController;
use App\Http\Controllers\NewsSubmissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [ArticleController::class, 'home'])->name('home');
Route::get('/cari', [ArticleController::class, 'search'])->name('search');
Route::get('/kategori/{slug}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/berita/{article:slug}', [ArticleController::class, 'show'])->name('article.show');

// Tautan klik iklan publik — hitung klik lalu teruskan ke target_url pengiklan.
Route::get('/iklan/{ad}/klik', AdClickController::class)->name('ads.click');

// Tombol share di halaman berita — hitung share lalu teruskan ke jaringan sosial.
Route::get('/berita/{article:slug}/bagikan/{platform}', [ArticleShareController::class, 'redirect'])->name('article.share');
Route::post('/berita/{article:slug}/bagikan-salin', [ArticleShareController::class, 'copy'])->name('article.share.copy');

// Form "Ajukan Berita" — menggantikan tombol Berlangganan di halaman utama.
Route::get('/ajukan-berita', [NewsSubmissionController::class, 'create'])->name('news-submission.create');
Route::post('/ajukan-berita', [NewsSubmissionController::class, 'store'])->name('news-submission.store');

// Halaman statis: Tentang Kami, Redaksi, dan Pedoman Media Siber.
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
    Route::get('/redaksi', [PageController::class, 'redaksi'])->name('redaksi');
    Route::get('/pedoman-media-siber', [PageController::class, 'pedomanMediaSiber'])->name('pedoman');
});

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

        Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register'])
            ->middleware('throttle:6,1')
            ->name('register.attempt');
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

        Route::get('/pengajuan-berita', [AdminNewsSubmissionController::class, 'index'])->name('news-submissions.index');
        Route::get('/pengajuan-berita/{newsSubmission}', [AdminNewsSubmissionController::class, 'show'])->name('news-submissions.show');
        Route::patch('/pengajuan-berita/{newsSubmission}/status', [AdminNewsSubmissionController::class, 'updateStatus'])->name('news-submissions.update-status');
        Route::delete('/pengajuan-berita/{newsSubmission}', [AdminNewsSubmissionController::class, 'destroy'])->name('news-submissions.destroy');

        // Pengaturan Akun — dikunci lewat konfirmasi ulang kata sandi.
        // Layar "Akses Terbatas" muncul kalau sesi konfirmasi belum ada/sudah kedaluwarsa.
        Route::get('/akun/verifikasi', [AdminAccountController::class, 'showConfirmPassword'])->name('account.confirm-password');
        Route::post('/akun/verifikasi', [AdminAccountController::class, 'confirmPassword'])->name('account.confirm-password.store');

        Route::middleware(RequirePassword::using('admin.account.confirm-password', 900))->group(function () {
            Route::get('/akun', [AdminAccountController::class, 'edit'])->name('account.edit');
            Route::put('/akun', [AdminAccountController::class, 'update'])->name('account.update');

            // Manajemen akun admin (aktifkan/nonaktifkan) — sensitif karena bisa
            // mengubah akses admin lain, jadi dikunci konfirmasi ulang kata sandi
            // yang sama seperti Pengaturan Akun.
            Route::get('/pengguna-admin', [AdminUserController::class, 'index'])->name('users.index');
            Route::patch('/pengguna-admin/{account}/toggle-active', [AdminUserController::class, 'toggleActive'])
                ->name('users.toggle-active');
        });
    });
});

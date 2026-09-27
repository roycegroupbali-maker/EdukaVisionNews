<?php

use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsSubmissionController as AdminNewsSubmissionController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\RunningTextController as AdminRunningTextController;
use App\Http\Controllers\Admin\StatReportController as AdminStatReportController;
use App\Http\Controllers\AdClickController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleShareController;
use App\Http\Controllers\NewsSubmissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// robots.txt dibuat dinamis (bukan file statis) supaya baris "Sitemap:" selalu
// memakai APP_URL yang benar, sama di lokal maupun produksi.
Route::get('/robots.txt', function () {
    // /cari dan /lacak-berita sengaja TIDAK di-Disallow di sini: keduanya sudah
    // ditandai <meta name="robots" content="noindex, follow"> di halamannya
    // masing-masing. Membiarkan crawler mengaksesnya (bukan Disallow) supaya
    // tag noindex itu benar-benar terbaca dan halaman dikeluarkan dari index,
    // alih-alih hanya "diblokir" tanpa pernah bisa di-deindex.
    $lines = [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        '',
        'Sitemap: '.url('/sitemap.xml'),
    ];

    return response(implode("\n", $lines), 200)
        ->header('Content-Type', 'text/plain');
})->name('robots');

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

// Lacak status pengajuan berita menggunakan nomor tiket + email.
Route::get('/lacak-berita', [NewsSubmissionController::class, 'track'])->name('news-submission.track');

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

        // Alur verifikasi berita: editor/jabatan berizin "articles.publish"
        // menyetujui (ACC) atau mengembalikan (revisi) berita yang diajukan wartawan.
        Route::middleware('permission:articles.publish')->group(function () {
            Route::patch('/articles/{article}/approve', [AdminArticleController::class, 'approve'])->name('articles.approve');
            Route::patch('/articles/{article}/reject', [AdminArticleController::class, 'reject'])->name('articles.reject');
        });

        // Laporan Statistik: akumulasi views & share per minggu/bulan/tahun + export.
        Route::get('/laporan-statistik', [AdminStatReportController::class, 'index'])->name('stats.index');
        Route::get('/laporan-statistik/export/excel', [AdminStatReportController::class, 'exportExcel'])->name('stats.export.excel');
        Route::get('/laporan-statistik/export/pdf', [AdminStatReportController::class, 'exportPdf'])->name('stats.export.pdf');

        Route::resource('categories', AdminCategoryController::class)->except(['show', 'create', 'edit']);

        Route::resource('running-texts', AdminRunningTextController::class)->except(['show', 'create', 'edit']);
        Route::patch('/running-texts/{runningText}/toggle-active', [AdminRunningTextController::class, 'toggleActive'])
            ->name('running-texts.toggle-active');

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

            // Manajemen akun admin (aktifkan/nonaktifkan/atur jabatan) — sensitif
            // karena bisa mengubah akses admin lain, jadi dikunci konfirmasi ulang
            // kata sandi yang sama seperti Pengaturan Akun. Mengatur jabatan butuh
            // izin "users.manage" tersendiri.
            Route::middleware('permission:users.manage')->group(function () {
                Route::get('/pengguna-admin', [AdminUserController::class, 'index'])->name('users.index');
                Route::patch('/pengguna-admin/{account}/toggle-active', [AdminUserController::class, 'toggleActive'])
                    ->name('users.toggle-active');
                Route::patch('/pengguna-admin/{account}/role', [AdminUserController::class, 'updateRole'])
                    ->name('users.update-role');
                // Akses khusus per akun (override dari default jabatan) —
                // dicek isSuperAdmin() lagi di controller karena lebih sensitif
                // daripada sekadar aktif/nonaktifkan atau ganti jabatan.
                Route::get('/pengguna-admin/{account}/akses', [AdminUserController::class, 'access'])
                    ->name('users.access');
                Route::patch('/pengguna-admin/{account}/akses', [AdminUserController::class, 'updateAccess'])
                    ->name('users.update-access');
            });

            // Manajemen Jabatan (custom role) & hak aksesnya — admin menentukan
            // jabatan apa saja yang ada dan sampai mana akses tiap jabatan.
            Route::middleware('permission:roles.manage')->group(function () {
                Route::resource('roles', AdminRoleController::class)->except(['show']);
            });
        });
    });
});

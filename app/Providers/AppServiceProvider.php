<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Article;
use App\Models\RunningText;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Halaman-halaman publik yang punya slot iklan dapat variabel $ads
        // berisi satu iklan aktif per slot: leaderboard, rectangle, midpage, mobile_bar.
        View::composer(
            ['home', 'categories.show', 'articles.show', 'search'],
            function ($view) {
                $view->with('ads', Ad::activeBySlot());
            }
        );

        // Ticker "TERKINI" di header (dipakai di hampir semua halaman publik).
        // Prioritas: Running Text yang diisi manual dari admin panel. Kalau belum
        // ada satupun yang aktif, jatuh balik (fallback) ke 5 berita terbit terbaru
        // seperti perilaku lama, supaya ticker tidak pernah kosong begitu saja.
        View::composer('partials.header', function ($view) {
            $runningTexts = RunningText::active()->ordered()->get();

            $latest = $runningTexts->isNotEmpty()
                ? $runningTexts->map(fn (RunningText $rt) => (object) [
                    'title' => $rt->text,
                    'slug' => null,
                    'url' => $rt->url,
                ])
                : Article::published()
                    ->latest('published_at')
                    ->limit(5)
                    ->get()
                    ->map(fn (Article $a) => (object) [
                        'title' => $a->title,
                        'slug' => $a->slug,
                        'url' => null,
                    ]);

            $view->with('latest', $latest);
        });
    }
}

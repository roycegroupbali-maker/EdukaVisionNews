<?php

namespace App\Providers;

use App\Models\Ad;
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
    }
}

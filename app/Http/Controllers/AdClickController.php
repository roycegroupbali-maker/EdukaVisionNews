<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\RedirectResponse;

class AdClickController extends Controller
{
    /**
     * Hitung klik lalu teruskan pengunjung ke tautan pengiklan.
     * Kalau iklan tidak punya target_url, kembalikan saja ke beranda.
     */
    public function __invoke(Ad $ad): RedirectResponse
    {
        $ad->increment('clicks');

        return redirect()->away($ad->target_url ?: route('home'));
    }
}

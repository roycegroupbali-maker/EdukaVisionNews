<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Pastikan user yang login adalah admin DAN sudah aktif. Kalau tidak,
     * tendang keluar ke halaman login admin dengan pesan yang jelas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            auth()->logout();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Akun ini tidak memiliki akses ke panel admin.']);
        }

        if (! $user->is_active) {
            auth()->logout();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Akun Anda belum diaktifkan oleh admin lain.']);
        }

        return $next($request);
    }
}

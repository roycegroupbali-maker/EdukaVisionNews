<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Middleware ini dipasang SETELAH middleware "admin" (yang memastikan
     * sudah login & akun aktif), jadi di sini tinggal cek jabatan/permission
     * spesifiknya saja. Dipakai lewat alias: middleware('permission:articles.publish').
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki hak akses untuk melakukan tindakan ini.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Daftar semua akun admin (termasuk yang masih menunggu aktivasi),
     * supaya bisa dikonfirmasi/diaktifkan atau dinonaktifkan.
     */
    public function index(): View
    {
        $accounts = User::where('is_admin', true)
            ->orderByRaw('is_active asc') // yang belum aktif ditampilkan lebih dulu supaya mudah dikonfirmasi
            ->latest()
            ->get();

        return view('admin.users.index', ['accounts' => $accounts]);
    }

    /**
     * Aktifkan / nonaktifkan akun admin. Admin tidak bisa menonaktifkan
     * akunnya sendiri supaya tidak ada yang terkunci keluar dari panel.
     */
    public function toggleActive(Request $request, User $account): RedirectResponse
    {
        if ($account->is($request->user())) {
            return back()->withErrors(['email' => 'Anda tidak bisa menonaktifkan akun Anda sendiri.']);
        }

        $account->update(['is_active' => ! $account->is_active]);

        return back()->with(
            'status',
            $account->is_active
                ? "Akun \"{$account->name}\" berhasil diaktifkan."
                : "Akun \"{$account->name}\" berhasil dinonaktifkan."
        );
    }
}

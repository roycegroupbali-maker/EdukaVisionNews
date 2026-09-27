<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function showRegister(): View
    {
        return view('admin.register');
    }

    /**
     * Pendaftaran akun admin baru. Akun langsung dibuat namun berstatus
     * nonaktif (is_active = false) sampai dikonfirmasi/diaktifkan oleh
     * admin lain yang sudah aktif, lewat menu "Akun Admin" di panel.
     * Tidak auto-login karena akun belum boleh dipakai dulu.
     *
     * Jabatan default untuk pendaftar baru adalah Wartawan (hak akses paling
     * terbatas: hanya bisa menulis & mengajukan berita). Admin bisa mengubah
     * jabatannya kapan saja lewat menu "Akun Admin" setelah aktivasi.
     */
    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => true,
            'is_active' => false,
            'role_id' => Role::where('slug', Role::WARTAWAN)->value('id'),
        ]);

        return redirect()
            ->route('admin.login')
            ->with('status', 'Pendaftaran berhasil. Akun Anda menunggu aktivasi dari admin lain sebelum bisa dipakai untuk masuk.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->onlyInput('email');
        }

        $user = Auth::user();

        if (! $user->is_admin) {
            Auth::logout();

            return back()
                ->withErrors(['email' => 'Akun ini tidak memiliki akses ke panel admin.'])
                ->onlyInput('email');
        }

        if (! $user->is_active) {
            Auth::logout();

            return back()
                ->withErrors(['email' => 'Akun Anda sudah terdaftar tapi belum diaktifkan oleh admin lain. Silakan hubungi pengelola panel admin.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

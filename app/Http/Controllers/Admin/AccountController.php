<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Layar "Akses Terbatas" — diminta setiap kali sesi konfirmasi kata sandi
     * sudah kedaluwarsa (lihat middleware password.confirm di routes/web.php).
     * Ini hanya berlaku untuk halaman yang memang sensitif (mis. kelola akun
     * orang lain / jabatan), BUKAN untuk halaman "Akun Saya" milik sendiri —
     * supaya siapa pun (jabatan apa saja) gampang ganti kata sandi & foto
     * profilnya sendiri tanpa harus login ulang / konfirmasi password dulu.
     */
    public function showConfirmPassword(): View
    {
        return view('admin.account.confirm-password');
    }

    public function confirmPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->input('password'), Auth::user()->password)) {
            return back()->withErrors(['password' => 'Kata sandi yang kamu masukkan salah.']);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('admin.account.edit'));
    }

    /**
     * Halaman Pengaturan Akun (Akun Saya) — bisa diakses semua jabatan tanpa
     * konfirmasi ulang kata sandi, supaya gampang ganti kata sandi & unggah
     * foto profil sendiri.
     */
    public function edit(): View
    {
        return view('admin.account.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar') && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
        }

        $user->save();

        return back()->with('status', 'Pengaturan akun berhasil disimpan.');
    }
}

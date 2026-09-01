<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Layar "Akses Terbatas" — diminta setiap kali sesi konfirmasi kata sandi
     * sudah kedaluwarsa (lihat middleware password.confirm di routes/web.php).
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
     * Halaman Pengaturan Akun — hanya bisa diakses setelah kata sandi
     * dikonfirmasi ulang lewat showConfirmPassword() di atas.
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
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('status', 'Pengaturan akun berhasil disimpan.');
    }
}

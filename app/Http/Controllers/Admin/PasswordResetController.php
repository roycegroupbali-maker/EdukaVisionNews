<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordChanged;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
use Throwable;

/**
 * Lupa / reset kata sandi untuk akun panel admin.
 *
 * Memakai Password Broker bawaan Laravel: token disimpan dalam bentuk hash di
 * tabel password_reset_tokens (sudah ada), hanya berlaku sekali pakai, kedaluwarsa
 * sesuai config('auth.passwords.users.expire') (60 menit) dan dibatasi frekuensinya
 * per akun (config 'throttle'). Kata sandi lama TIDAK PERNAH dikirim lewat email.
 */
class PasswordResetController extends Controller
{
    /** Pesan yang sama dipakai untuk email terdaftar maupun tidak (anti user-enumeration). */
    private const GENERIC_STATUS = 'Jika email tersebut terdaftar dan akunnya aktif, tautan untuk mengatur ulang kata sandi sudah kami kirim. Periksa kotak masuk (dan folder spam) Anda.';

    public function showForgot(): View
    {
        return view('admin.forgot-password');
    }

    public function sendLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        try {
            // Hanya akun admin yang aktif yang bisa menerima tautan reset.
            Password::sendResetLink([
                'email' => $data['email'],
                'is_admin' => true,
                'is_active' => true,
            ]);
        } catch (Throwable $e) {
            // Gagal kirim email tidak boleh membocorkan apa pun ke pengunjung.
            Log::warning('Gagal mengirim email reset kata sandi admin: '.$e->getMessage());
        }

        return back()->with('status', self::GENERIC_STATUS);
    }

    public function showReset(Request $request, string $token): View
    {
        return view('admin.reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $changedUser = null;

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $data['token'],
                'is_admin' => true,
                'is_active' => true,
            ],
            function (User $user, string $password) use (&$changedUser) {
                // Cast 'hashed' di model User yang meng-hash kata sandi baru.
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                // Putuskan semua sesi login lama milik akun ini (jika sesi disimpan di database).
                if (config('session.driver') === 'database') {
                    DB::table(config('session.table', 'sessions'))
                        ->where('user_id', $user->getKey())
                        ->delete();
                }

                event(new PasswordReset($user));

                $changedUser = $user;
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.']);
        }

        if ($changedUser) {
            try {
                Mail::to($changedUser->email)->send(new AdminPasswordChanged($changedUser));
            } catch (Throwable $e) {
                Log::warning('Gagal mengirim email pemberitahuan perubahan kata sandi: '.$e->getMessage(), [
                    'user_id' => $changedUser->id,
                ]);
            }
        }

        return redirect()
            ->route('admin.login')
            ->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru Anda.');
    }
}

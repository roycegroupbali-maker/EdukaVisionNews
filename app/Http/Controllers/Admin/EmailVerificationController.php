<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Verifikasi email akun admin secara mandiri (opt-in) dan TIDAK memblokir login.
 * Hanya mengisi kolom users.email_verified_at yang sudah ada (tanpa migrasi).
 * Email hanya terkirim saat pemilik akun menekan tombol "Kirim email verifikasi".
 */
class EmailVerificationController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return back()->with('status', 'Email Anda sudah terverifikasi.');
        }

        try {
            Mail::to($user->email)->send(new AdminVerifyEmail($user));
        } catch (Throwable $e) {
            Log::warning('Gagal mengirim email verifikasi: '.$e->getMessage(), ['user_id' => $user->id]);

            return back()->withErrors(['verification' => 'Email verifikasi belum bisa dikirim. Silakan coba lagi beberapa saat lagi.']);
        }

        return back()->with('status', 'Email verifikasi sudah dikirim ke '.$user->email.'. Periksa kotak masuk (dan folder spam) Anda.');
    }

    public function verify(Request $request, string $id, string $hash): RedirectResponse
    {
        $user = Auth::user();

        // Tautan harus milik akun yang sedang login dan email-nya masih sama dengan saat tautan dibuat.
        if ((string) $user->getKey() !== $id || ! hash_equals(sha1($user->email), $hash)) {
            abort(403, 'Tautan verifikasi tidak valid untuk akun ini.');
        }

        if (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        return redirect()->route('admin.dashboard')->with('status', 'Email Anda berhasil diverifikasi.');
    }
}

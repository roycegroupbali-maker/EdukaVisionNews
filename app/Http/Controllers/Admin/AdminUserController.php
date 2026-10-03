<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminAccountActivated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Daftar semua akun admin (termasuk yang masih menunggu aktivasi),
     * supaya bisa dikonfirmasi/diaktifkan, dinonaktifkan, atau diatur
     * jabatannya (siapa jadi Wartawan, Editor, atau jabatan custom lain).
     */
    public function index(): View
    {
        $accounts = User::where('is_admin', true)
            ->with('role')
            ->orderByRaw('is_active asc') // yang belum aktif ditampilkan lebih dulu supaya mudah dikonfirmasi
            ->latest()
            ->get();

        $roles = Role::orderByDesc('is_system')->orderBy('name')->get();

        return view('admin.users.index', ['accounts' => $accounts, 'roles' => $roles]);
    }

    /**
     * Ubah jabatan (role) seorang pengguna panel. Inilah tempat admin
     * mengatur "sampai mana" akses tiap orang — mis. menjadikan seseorang
     * Editor supaya bisa menyetujui berita, atau membuatnya jabatan custom.
     */
    public function updateRole(Request $request, User $account): RedirectResponse
    {
        if ($account->is($request->user()) && ! $request->user()->isSuperAdmin()) {
            return back()->withErrors(['role' => 'Anda tidak bisa mengubah jabatan Anda sendiri.']);
        }

        $data = $request->validate([
            'role_id' => ['nullable', Rule::exists('roles', 'id')],
        ]);

        $account->update(['role_id' => $data['role_id'] ?? null]);

        return back()->with('status', "Jabatan \"{$account->name}\" berhasil diperbarui menjadi \"{$account->fresh()->role_name}\".");
    }

    /**
     * Halaman "Akses Khusus" per akun — dibuka dengan klik email di daftar
     * Akun Admin. Menampilkan checkbox hak akses yang sama seperti halaman
     * Jabatan, sudah terisi sesuai akses efektif akun ini saat ini (dari
     * override kalau ada, atau dari jabatannya kalau belum ada override).
     *
     * Khusus Super Admin — bukan sekadar permission "users.manage" — karena
     * fitur ini bisa mengubah akses individual siapa pun, jadi risikonya
     * lebih tinggi daripada sekadar aktif/nonaktifkan akun atau ganti jabatan.
     */
    public function access(Request $request, User $account): View
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Super Admin yang bisa mengatur akses khusus per akun.');

        return view('admin.users.access', [
            'account' => $account,
            'permissionCatalog' => Role::permissionCatalog(),
        ]);
    }

    /**
     * Simpan akses khusus (override) untuk satu akun, atau kembalikan ke
     * default jabatannya lewat tombol "reset".
     */
    public function updateAccess(Request $request, User $account): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Super Admin yang bisa mengatur akses khusus per akun.');

        if ($account->isSuperAdmin()) {
            return back()->withErrors(['access' => 'Akses Super Admin selalu penuh dan tidak bisa diubah.']);
        }

        if ($request->boolean('reset')) {
            $account->update(['permissions_override' => null]);

            return redirect()->route('admin.users.access', $account)
                ->with('status', "Akses \"{$account->name}\" dikembalikan ke default jabatan \"{$account->role_name}\".");
        }

        $catalog = array_keys(Role::permissionCatalog());
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [Rule::in($catalog)],
        ]);

        $account->update(['permissions_override' => array_values($data['permissions'] ?? [])]);

        return redirect()->route('admin.users.access', $account)
            ->with('status', "Akses khusus untuk \"{$account->name}\" berhasil disimpan.");
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

        // Beri tahu pemilik akun lewat email saat akunnya diaktifkan (gagal kirim tidak mengganggu proses).
        if ($account->is_active) {
            try {
                Mail::to($account->email)->send(new AdminAccountActivated($account));
            } catch (\Throwable $e) {
                Log::warning('Gagal mengirim email aktivasi akun: '.$e->getMessage(), ['user_id' => $account->id]);
            }
        }

        return back()->with(
            'status',
            $account->is_active
                ? "Akun \"{$account->name}\" berhasil diaktifkan."
                : "Akun \"{$account->name}\" berhasil dinonaktifkan."
        );
    }
}

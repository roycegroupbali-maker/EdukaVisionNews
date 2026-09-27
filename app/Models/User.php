<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'is_active', 'role_id', 'permissions_override', 'avatar_path'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Cek hak akses user. Urutannya:
     * 1) Super Admin selalu penuh, apa pun kondisinya.
     * 2) Kalau akun ini punya "akses khusus" (permissions_override diisi,
     *    bisa jadi array kosong), itu yang dipakai — menimpa default jabatan.
     *    Ini untuk pengecualian per orang, BUKAN cara yang direkomendasikan
     *    untuk mengatur akses banyak orang (pakai Jabatan/Role untuk itu).
     * 3) Kalau tidak ada override, pakai default hak akses jabatannya.
     * User tanpa jabatan & tanpa override dianggap tidak punya izin apa pun.
     */
    public function hasPermission(string $key): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->permissions_override !== null) {
            return in_array($key, $this->permissions_override, true);
        }

        return (bool) $this->role?->hasPermission($key);
    }

    /**
     * Hak akses efektif akun ini saat ini (dari override kalau ada, kalau
     * tidak dari jabatannya). Dipakai untuk mengisi checkbox di halaman
     * "Akses Khusus" per akun.
     */
    public function effectivePermissions(): array
    {
        if ($this->isSuperAdmin()) {
            return array_keys(Role::permissionCatalog());
        }

        return $this->permissions_override ?? $this->role?->permissions ?? [];
    }

    /**
     * True kalau akun ini memakai akses khusus (override), bukan default
     * dari jabatannya.
     */
    public function hasCustomAccess(): bool
    {
        return $this->permissions_override !== null;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->slug === Role::SUPER_ADMIN;
    }

    /**
     * Nama jabatan untuk ditampilkan di panel (mis. di sidebar & daftar akun).
     */
    public function getRoleNameAttribute(): string
    {
        return $this->role?->name ?? 'Belum ada jabatan';
    }

    /**
     * URL foto profil, atau null kalau belum diunggah (sidebar & halaman akun
     * lalu menampilkan inisial nama sebagai fallback).
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar_path) : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'permissions_override' => 'array',
        ];
    }
}

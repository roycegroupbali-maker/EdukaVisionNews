<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'permissions', 'is_system'];

    protected $casts = [
        'permissions' => 'array',
        'is_system' => 'boolean',
    ];

    /**
     * Slug role sistem yang dibuat lewat seeder & tidak boleh dihapus.
     * Super Admin juga tidak boleh diubah izin/permission-nya lewat panel
     * (selalu penuh) supaya minimal ada satu akun yang tidak bisa terkunci.
     */
    public const SUPER_ADMIN = 'super-admin';

    public const EDITOR = 'editor';

    public const WARTAWAN = 'wartawan';

    /**
     * Katalog seluruh hak akses (permission) yang tersedia di panel admin.
     * Dipakai untuk membangun form checkbox di halaman Jabatan, dan untuk
     * validasi supaya admin tidak bisa menyimpan key permission sembarangan.
     *
     * @return array<string, string>
     */
    public static function permissionCatalog(): array
    {
        return [
            'articles.view_all' => 'Melihat semua berita milik semua wartawan (bukan hanya miliknya sendiri)',
            'articles.create' => 'Menulis & mengajukan berita baru',
            'articles.publish' => 'Meninjau pengajuan, menyetujui/menolak (ACC/revisi), dan mempublikasikan berita',
            'articles.delete' => 'Menghapus berita',
            'categories.manage' => 'Mengelola kategori berita',
            'running_texts.manage' => 'Mengelola running text (teks berjalan)',
            'ads.manage' => 'Mengelola iklan / ads',
            'news_submissions.manage' => 'Mengelola pengajuan berita dari pembaca publik',
            'comments.manage' => 'Memoderasi komentar pembaca (setujui, sembunyikan, hapus)',
            'stats.view' => 'Melihat & mengekspor laporan statistik',
            'users.manage' => 'Mengaktifkan/menonaktifkan akun & mengatur jabatan pengguna panel',
            'roles.manage' => 'Membuat, mengubah, dan menghapus jabatan beserta hak aksesnya',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $key): bool
    {
        if ($this->slug === self::SUPER_ADMIN) {
            return true;
        }

        return in_array($key, $this->permissions ?? [], true);
    }
}

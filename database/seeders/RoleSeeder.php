<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Tiga jabatan bawaan sistem. Admin tetap bisa menambah jabatan custom
     * lain lewat menu "Jabatan" di panel, tapi tiga ini tidak bisa dihapus
     * supaya alur verifikasi berita & login panel selalu punya minimal
     * satu jabatan dengan akses penuh (Super Admin).
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['slug' => Role::SUPER_ADMIN],
            [
                'name' => 'Super Admin',
                'description' => 'Akses penuh ke seluruh fitur panel, termasuk mengelola jabatan & hak akses pengguna lain.',
                'permissions' => array_keys(Role::permissionCatalog()),
                'is_system' => true,
            ]
        );

        Role::updateOrCreate(
            ['slug' => Role::EDITOR],
            [
                'name' => 'Editor',
                'description' => 'Meninjau, menyetujui/menolak, dan mempublikasikan berita yang diajukan wartawan.',
                'permissions' => [
                    'articles.view_all',
                    'articles.create',
                    'articles.publish',
                    'articles.delete',
                    'categories.manage',
                    'running_texts.manage',
                    'news_submissions.manage',
                    'comments.manage',
                    'stats.view',
                ],
                'is_system' => true,
            ]
        );

        Role::updateOrCreate(
            ['slug' => Role::WARTAWAN],
            [
                'name' => 'Wartawan',
                'description' => 'Menulis & mengajukan berita. Berita baru berstatus "Menunggu Tinjauan" sampai disetujui editor.',
                'permissions' => [
                    'articles.create',
                ],
                'is_system' => true,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun Super Admin default supaya panel admin langsung bisa
     * dipakai setelah `php artisan migrate --seed`.
     *
     * PENTING: ganti password ini setelah login pertama kali di production.
     */
    public function run(): void
    {
        $superAdminRoleId = Role::where('slug', Role::SUPER_ADMIN)->value('id');

        User::updateOrCreate(
            ['email' => 'edukavisionid@gmail.com'],
            [
                'name' => 'Admin EdukaVisionNews',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'is_active' => true,
                'role_id' => $superAdminRoleId,
                'email_verified_at' => now(),
            ]
        );
    }
}

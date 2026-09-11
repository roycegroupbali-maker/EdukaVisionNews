<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun admin default supaya panel admin langsung bisa dipakai
     * setelah `php artisan migrate --seed`.
     *
     * PENTING: ganti password ini setelah login pertama kali di production.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'edukavisionid@gmail.com'],
            [
                'name' => 'Admin EdukaVisionNews',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}

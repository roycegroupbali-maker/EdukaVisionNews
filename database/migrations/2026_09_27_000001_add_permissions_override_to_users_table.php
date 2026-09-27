<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Override akses per akun (bukan per jabatan). NULL = akun memakai
     * hak akses default dari jabatannya (Role) — ini kondisi yang
     * direkomendasikan untuk hampir semua akun. Diisi array (walau kosong
     * []) hanya kalau Super Admin sengaja mengecualikan satu akun tertentu
     * dari default jabatannya lewat halaman "Akses Khusus" per akun.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions_override')->nullable()->after('role_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('permissions_override');
        });
    }
};

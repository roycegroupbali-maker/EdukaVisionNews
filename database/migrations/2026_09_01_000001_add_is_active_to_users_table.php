<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menandai apakah akun (khususnya admin hasil pendaftaran mandiri) sudah
     * dikonfirmasi/diaktifkan oleh admin lain. Default true supaya akun yang
     * sudah ada sekarang tidak ikut terkunci mendadak.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Nama editor yang tampil di byline (gaya tvOne: "Reporter : ... Editor : ...").
            // Opsional: kalau kosong, byline memakai nama akun editor yang menyetujui berita.
            $table->string('editor_name', 100)->nullable()->after('editor_id');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('editor_name');
        });
    }
};

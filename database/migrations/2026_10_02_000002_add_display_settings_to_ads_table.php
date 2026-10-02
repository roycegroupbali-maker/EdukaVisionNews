<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // cover = isi penuh bingkai (bisa terpotong), contain = gambar utuh, fill = diregangkan
            $table->string('fit', 10)->default('cover')->after('image_path');
            // Titik fokus gambar (0-100%): 0 = kiri/atas, 50 = tengah, 100 = kanan/bawah
            $table->unsignedTinyInteger('pos_x')->default(50)->after('fit');
            $table->unsignedTinyInteger('pos_y')->default(50)->after('pos_x');
            // Perbesaran gambar dalam persen (100 = normal)
            $table->unsignedSmallInteger('zoom')->default(100)->after('pos_y');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['fit', 'pos_x', 'pos_y', 'zoom']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rekap views & share per berita per hari.
     *
     * Kolom articles.views / articles.shares tetap menjadi total kumulatif.
     * Tabel ini menyimpan rinciannya per tanggal sehingga bisa dijumlahkan
     * per minggu, bulan, dan tahun untuk Laporan Statistik.
     */
    public function up(): void
    {
        Schema::create('article_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('shares')->default(0);

            $table->unique(['article_id', 'date']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_stats');
    }
};

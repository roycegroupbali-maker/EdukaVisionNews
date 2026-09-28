<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Satu baris = satu pengunjung (dikenali lewat cookie anonim visitor_id)
     * sudah menyukai satu berita. Constraint UNIQUE di bawah adalah lapisan
     * anti-spam utama: mustahil satu visitor_id tercatat like dua kali untuk
     * berita yang sama walau tombolnya diklik berkali-kali atau requestnya
     * dikirim paralel.
     */
    public function up(): void
    {
        Schema::create('article_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_id', 64);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'visitor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_likes');
    }
};

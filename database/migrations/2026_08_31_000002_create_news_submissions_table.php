<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('title');
            $table->text('content');
            $table->string('image_path')->nullable();

            // pending -> menunggu ditinjau redaksi, reviewed -> sudah dibaca,
            // approved -> disetujui untuk diangkat jadi berita, rejected -> ditolak.
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_submissions');
    }
};

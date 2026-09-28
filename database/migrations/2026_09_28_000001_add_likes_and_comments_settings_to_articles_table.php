<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Jumlah like — fitur tentative, dikontrol lewat config('features.likes_enabled').
            $table->unsignedInteger('likes')->default(0)->after('shares');

            // Admin/editor bisa menonaktifkan komentar untuk berita tertentu
            // (mis. berita sensitif) meskipun saklar global komentar aktif.
            $table->boolean('comments_enabled')->default(true)->after('is_sponsored');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['likes', 'comments_enabled']);
        });
    }
};

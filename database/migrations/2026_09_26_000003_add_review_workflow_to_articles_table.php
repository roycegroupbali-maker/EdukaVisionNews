<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan alur verifikasi berita:
     * - status: draft -> pending (menunggu tinjauan editor) -> revisi (dikembalikan) -> published
     * - author_id: wartawan/penulis yang membuat berita (relasi ke users)
     * - editor_id: editor yang meninjau/menyetujui/menolak
     * - submitted_at / reviewed_at / review_note: jejak audit proses tinjauan
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('status', 20)->default(Article::STATUS_DRAFT)->after('category_id');
            $table->foreignId('author_id')->nullable()->after('author')
                ->constrained('users')->nullOnDelete();
            $table->foreignId('editor_id')->nullable()->after('author_id')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable()->after('published_at');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->text('review_note')->nullable()->after('reviewed_at');
        });

        // Backfill data lama: berita yang sudah tayang (published_at terisi &
        // sudah lewat) ditandai 'published', sisanya jadi 'draft'. Supaya
        // tampilan publik (home, kategori, sitemap) tidak berubah untuk
        // konten yang sudah ada sebelum fitur verifikasi ini dibuat.
        DB::table('articles')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->update(['status' => Article::STATUS_PUBLISHED]);
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('editor_id');
            $table->dropConstrainedForeignId('author_id');
            $table->dropColumn(['status', 'submitted_at', 'reviewed_at', 'review_note']);
        });
    }
};

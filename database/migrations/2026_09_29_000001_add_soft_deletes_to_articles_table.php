<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tempat sampah berita: berita yang "dihapus" hanya ditandai deleted_at
     * (hilang dari web), datanya tetap ada & hanya Super Admin yang bisa
     * memulihkannya. deleted_by mencatat siapa yang menghapus.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['deleted_by', 'deleted_at']);
        });
    }
};

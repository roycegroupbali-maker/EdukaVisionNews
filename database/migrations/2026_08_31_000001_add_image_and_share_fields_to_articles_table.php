<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Foto berita yang diunggah admin (menggantikan/melengkapi art generatif).
            $table->string('image_path')->nullable()->after('art_pattern');
            $table->string('image_caption')->nullable()->after('image_path');
            $table->string('image_source')->nullable()->after('image_caption'); // kredit/sumber foto, mis. "Foto: Antara"
            $table->string('image_alt')->nullable()->after('image_source'); // teks alternatif untuk SEO & aksesibilitas

            // Tag topik berita, disimpan sebagai teks dipisah koma dan ditampilkan
            // di akhir artikel, seperti pada portal berita pada umumnya.
            $table->text('tags')->nullable()->after('image_alt');

            // Jumlah berita ini dibagikan (share) oleh pembaca.
            $table->unsignedInteger('shares')->default(0)->after('views');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'image_path', 'image_caption', 'image_source', 'image_alt', 'tags', 'shares',
            ]);
        });
    }
};

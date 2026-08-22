<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tag_class')->default('berita'); // css class used on <span class="tag {tag_class}">
            $table->string('bar_color')->default('var(--red)'); // css var used for section bar accent
            $table->string('anchor')->nullable(); // legacy in-page anchor id (berita, dunia, ...)
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

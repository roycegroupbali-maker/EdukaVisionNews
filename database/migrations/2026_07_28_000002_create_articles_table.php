<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subcategory')->nullable(); // small label e.g. "Ekonomi", "Sains"
            $table->text('excerpt');
            $table->longText('content'); // paragraphs separated by blank lines
            $table->string('author')->default('Redaksi EdukaVisionNews');
            $table->unsignedSmallInteger('read_minutes')->default(4);
            $table->unsignedInteger('views')->default(0);

            // placeholder art (svg is generated in blade from these fields, no image upload needed)
            $table->string('art_color1')->default('#14213D');
            $table->string('art_color2')->default('#2a3f75');
            $table->string('art_pattern')->default('wave'); // wave|circles|triangle|grid|dots|arrow

            // recipe-only optional fields
            $table->unsignedSmallInteger('recipe_minutes')->nullable();
            $table->unsignedSmallInteger('recipe_servings')->nullable();
            $table->string('recipe_difficulty')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_sponsored')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

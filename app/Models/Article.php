<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'subcategory', 'excerpt', 'content',
        'author', 'read_minutes', 'views', 'art_color1', 'art_color2', 'art_pattern',
        'recipe_minutes', 'recipe_servings', 'recipe_difficulty',
        'is_featured', 'is_sponsored', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_sponsored' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Split the long-form content into paragraphs for the detail view.
     */
    public function getParagraphsAttribute(): array
    {
        return collect(preg_split("/\r?\n\r?\n/", trim($this->content)))
            ->map(fn ($p) => trim($p))
            ->filter()
            ->values()
            ->all();
    }

    public function getReadableDateAttribute(): string
    {
        return $this->published_at?->translatedFormat('d F Y, H:i') ?? '';
    }
}

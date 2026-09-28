<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Satu baris = satu pengunjung anonim (dikenali lewat cookie visitor_id)
 * sudah menyukai satu berita. Lihat migration create_article_likes_table
 * untuk constraint UNIQUE yang mencegah like ganda dari pengunjung sama.
 */
class ArticleLike extends Model
{
    protected $fillable = ['article_id', 'visitor_id', 'ip_address'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\UniqueConstraintViolationException;
use InvalidArgumentException;
use Throwable;

/**
 * Rekap views & share satu berita untuk satu tanggal.
 */
class ArticleStat extends Model
{
    public $timestamps = false;

    protected $fillable = ['article_id', 'date', 'views', 'shares'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Tambah 1 ke views atau shares untuk berita tersebut pada hari ini
     * (mengikuti config('stats.timezone')).
     *
     * Aman dipanggil bersamaan: kalau baris hari ini belum ada, dibuat;
     * kalau dua request membuatnya bersamaan, yang kalah cukup menambah.
     * Kegagalan pencatatan tidak boleh merusak halaman pembaca, jadi
     * error hanya dilaporkan ke log.
     */
    public static function hit(int $articleId, string $column): void
    {
        if (! in_array($column, ['views', 'shares'], true)) {
            throw new InvalidArgumentException("Kolom statistik tidak dikenal: {$column}");
        }

        try {
            $date = now(config('stats.timezone'))->toDateString();

            $row = fn () => static::query()
                ->where('article_id', $articleId)
                ->where('date', $date);

            if ($row()->increment($column) > 0) {
                return;
            }

            try {
                static::query()->create([
                    'article_id' => $articleId,
                    'date' => $date,
                    $column => 1,
                ]);
            } catch (UniqueConstraintViolationException) {
                $row()->increment($column);
            }
        } catch (Throwable $e) {
            report($e);
        }
    }
}

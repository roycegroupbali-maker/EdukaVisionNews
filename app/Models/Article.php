<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Alur status verifikasi berita:
     * draft   -> masih dikerjakan penulis, belum diajukan
     * pending -> diajukan wartawan, menunggu tinjauan editor
     * revisi  -> dikembalikan editor, perlu diperbaiki lalu diajukan ulang
     * published -> sudah disetujui editor & tayang ke publik
     */
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING = 'pending';

    public const STATUS_REVISION = 'revisi';

    public const STATUS_PUBLISHED = 'published';

    /** @return array<string, string> */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Draf',
            self::STATUS_PENDING => 'Menunggu Tinjauan',
            self::STATUS_REVISION => 'Perlu Revisi',
            self::STATUS_PUBLISHED => 'Tayang',
        ];
    }

    protected $fillable = [
        'category_id', 'title', 'slug', 'subcategory', 'excerpt', 'content',
        'author', 'author_id', 'editor_id', 'status',
        'read_minutes', 'views', 'shares', 'art_color1', 'art_color2', 'art_pattern',
        'image_path', 'image_caption', 'image_source', 'image_alt', 'tags',
        'youtube_url', 'image_link',
        'recipe_minutes', 'recipe_servings', 'recipe_difficulty',
        'is_featured', 'is_sponsored', 'published_at',
        'submitted_at', 'reviewed_at', 'review_note',
        'comments_enabled',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_sponsored' => 'boolean',
        'comments_enabled' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(ArticleStat::class);
    }

    /**
     * Semua catatan like (anti-spam) untuk berita ini. Fitur tentative,
     * lihat config('features.likes_enabled').
     */
    public function likesRecords(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    /** Seluruh komentar (semua status) — dipakai di panel moderasi admin. */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /** Komentar yang sudah disetujui & boleh tampil di halaman publik. */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->where('status', Comment::STATUS_APPROVED)
            ->latest();
    }

    /**
     * Wartawan/penulis yang membuat berita ini (bisa null untuk berita lama
     * sebelum fitur alur verifikasi ada, atau berita yang dibuat via seeder).
     */
    public function authorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Editor yang terakhir meninjau (menyetujui/menolak) berita ini.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Akun yang menghapus berita ini (terisi saat masuk tempat sampah).
     */
    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'badge-green',
            self::STATUS_PENDING => 'badge-blue',
            self::STATUS_REVISION => 'badge-red',
            default => 'badge-gray',
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Versi HTML aman dari isi berita, siap dirender langsung dengan {!! !!}
     * di halaman detail. Mendukung dua bentuk data pada kolom `content`:
     *
     * 1. Berita lama / belum pernah disunting rich text editor: teks polos,
     *    paragraf dipisah baris kosong -> tiap paragraf otomatis dibungkus
     *    <p> dan di-escape (nl2br untuk baris tunggal di dalam paragraf).
     * 2. Berita baru dari rich text editor (tombol Bold/Italic/Underline):
     *    kolom sudah berisi HTML minimal (<p>, <strong>, <em>, <u>, dst) ->
     *    disaring lewat HtmlSanitizer supaya tag/atribut berbahaya apa pun
     *    tidak pernah bisa lolos ke halaman publik.
     */
    public function getContentHtmlAttribute(): string
    {
        $raw = (string) $this->content;

        if (trim($raw) === '') {
            return '';
        }

        // Heuristik: kalau strip_tags() tidak mengubah apa pun, berarti
        // kolom ini belum mengandung tag HTML sama sekali -> format lama.
        $looksLikeHtml = $raw !== strip_tags($raw);

        if (! $looksLikeHtml) {
            return collect(preg_split("/\r?\n\r?\n/", trim($raw)))
                ->map(fn ($p) => trim($p))
                ->filter()
                ->map(fn ($p) => '<p>'.nl2br(e($p), false).'</p>')
                ->implode('');
        }

        return \App\Support\HtmlSanitizer::clean($raw);
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

    /**
     * URL publik foto berita yang diunggah admin, atau null kalau belum ada
     * (artinya masih memakai art generatif dari partials.art).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /**
     * Ambil ID video YouTube (11 karakter) dari berbagai format URL:
     * watch?v=, youtu.be/, embed/, shorts/, live/
     * Mengembalikan null kalau URL kosong atau formatnya tidak dikenali.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (! $this->youtube_url) {
            return null;
        }

        $pattern = '~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})~';

        return preg_match($pattern, $this->youtube_url, $m) ? $m[1] : null;
    }

    /**
     * URL thumbnail video YouTube (hqdefault selalu tersedia untuk semua video).
     * Dipakai sebagai gambar cadangan kalau berita tidak punya foto unggahan.
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        $id = $this->youtube_id;

        return $id ? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg" : null;
    }

    /**
     * Pecah string tag (dipisah koma) jadi array bersih untuk ditampilkan
     * sebagai chip/pill di akhir artikel, seperti portal berita pada umumnya.
     *
     * @return array<int, string>
     */
    public function getTagsArrayAttribute(): array
    {
        return collect(explode(',', (string) $this->tags))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
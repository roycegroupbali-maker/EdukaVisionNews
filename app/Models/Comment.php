<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /**
     * Alur moderasi komentar:
     * pending  -> baru dikirim pembaca, menunggu tinjauan admin/editor
     * approved -> disetujui, tampil publik di bawah berita
     * hidden   -> disembunyikan/ditolak admin-editor (tidak dihapus permanen)
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_HIDDEN = 'hidden';

    protected $fillable = ['article_id', 'name', 'body', 'status', 'ip_address', 'moderated_by', 'moderated_at'];

    protected $casts = [
        'moderated_at' => 'datetime',
    ];

    /** @return array<string, string> */
    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING => 'Menunggu Moderasi',
            self::STATUS_APPROVED => 'Tayang',
            self::STATUS_HIDDEN => 'Disembunyikan',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
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
            self::STATUS_APPROVED => 'badge-green',
            self::STATUS_HIDDEN => 'badge-red',
            default => 'badge-blue',
        };
    }
}

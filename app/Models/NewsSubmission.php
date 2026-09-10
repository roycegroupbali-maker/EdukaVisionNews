<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsSubmission extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * Label status yang tampil di panel admin.
     */
    public const STATUSES = [
        self::STATUS_PENDING => 'Menunggu Ditinjau',
        self::STATUS_REVIEWED => 'Sudah Ditinjau',
        self::STATUS_APPROVED => 'Disetujui',
        self::STATUS_REJECTED => 'Ditolak',
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'title', 'content', 'image_path', 'status', 'admin_note',
    ];

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Warna heks per status, dipakai untuk badge di email transaksional
     * (email tidak bisa membaca custom property CSS seperti di web).
     */
    public const STATUS_COLORS = [
        self::STATUS_PENDING => ['bg' => '#F1ECE1', 'text' => '#6B6558', 'border' => '#e4ddcd'],
        self::STATUS_REVIEWED => ['bg' => '#FBF1DC', 'text' => '#86671A', 'border' => '#e9d9ab'],
        self::STATUS_APPROVED => ['bg' => '#E9F3EF', 'text' => '#1B4B43', 'border' => '#bcded1'],
        self::STATUS_REJECTED => ['bg' => '#FBEAEA', 'text' => '#9c1e23', 'border' => '#f0c4c4'],
    ];

    public function getStatusColorAttribute(): array
    {
        return self::STATUS_COLORS[$this->status] ?? self::STATUS_COLORS[self::STATUS_PENDING];
    }
}

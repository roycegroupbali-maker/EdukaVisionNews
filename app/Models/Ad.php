<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ad extends Model
{
    use HasFactory;

    /**
     * Slot yang tersedia beserta label & ukuran yang ditampilkan di panel admin.
     * Key harus sama persis dengan yang dipakai di Blade (partials & halaman).
     */
    public const SLOTS = [
        'leaderboard' => 'Leaderboard (970 × 90) — atas halaman',
        'rectangle' => 'Rectangle (300 × 600) — samping widget',
        'midpage' => 'Tengah Halaman (728 × 250)',
        'mobile_bar' => 'Sticky Bar Mobile',
    ];

    protected $fillable = [
        'title', 'slot', 'image_path', 'target_url', 'cta_text', 'advertiser',
        'is_active', 'starts_at', 'ends_at', 'sort_order', 'impressions', 'clicks',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function scopeForSlot(Builder $query, string $slot): Builder
    {
        return $query->where('slot', $slot);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    public function getSlotLabelAttribute(): string
    {
        return self::SLOTS[$this->slot] ?? $this->slot;
    }

    /**
     * Ambil satu iklan aktif teratas untuk tiap slot, dipakai oleh View Composer
     * supaya blade cukup memanggil $ads['leaderboard'] dsb.
     *
     * @return array<string, Ad>
     */
    public static function activeBySlot(): array
    {
        return self::active()
            ->orderBy('sort_order')
            ->latest()
            ->get()
            ->groupBy('slot')
            ->map(fn ($group) => $group->first())
            ->all();
    }
}

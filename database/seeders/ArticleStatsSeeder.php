<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleStat;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

/**
 * Isi article_stats untuk semua berita yang sudah dibuat ArticleSeeder,
 * lalu sinkronkan kolom articles.shares supaya totalnya cocok dengan
 * rincian harian yang baru dibuat.
 *
 * PENTING: ini data histori SIMULASI untuk keperluan demo/pengujian
 * Laporan Statistik (filter minggu/bulan/tahun) saja. Setiap kali
 * dijalankan, seluruh isi article_stats dihapus lalu dibuat ulang —
 * jangan jalankan di database produksi yang sudah punya rekap asli.
 *
 * Cara pakai:
 *   php artisan db:seed --class=Database\\Seeders\\ArticleStatSeeder
 * (otomatis ikut jalan juga lewat `php artisan migrate --seed` /
 * `php artisan db:seed`, karena sudah didaftarkan di DatabaseSeeder).
 */
class ArticleStatSeeder extends Seeder
{
    /** Rentang total simulasi historis (hari), dihitung mundur dari hari ini. */
    private const HISTORY_DAYS = 360;

    /** Seberapa cepat trafik satu berita meluruh setelah "titik terbit" simulasinya. */
    private const DECAY_DAYS = 45;

    /** Persentase share terhadap views, dipakai untuk membuat total share sintetis. */
    private const SHARE_RATIO_MIN = 4;

    private const SHARE_RATIO_MAX = 16;

    public function run(): void
    {
        $tz = config('stats.timezone');
        $today = CarbonImmutable::now($tz)->startOfDay();

        // Data lama dihapus dulu supaya seeder ini aman dijalankan berkali-kali
        // (idempotent) tanpa menumpuk baris basi dari histori acak sebelumnya.
        ArticleStat::query()->delete();

        // Diurutkan dari yang paling baru terbit supaya berita yang lebih baru
        // di ArticleSeeder mendapat titik awal simulasi yang lebih dekat ke hari ini,
        // sementara yang lebih lama tersebar mundur hingga ~setahun ke belakang.
        $articles = Article::orderByDesc('published_at')->get();
        $lastIndex = max($articles->count() - 1, 1);

        $articles->values()->each(function (Article $article, int $rank) use ($today, $lastIndex): void {
            $spread = (int) round(($rank / $lastIndex) * self::HISTORY_DAYS);
            $startDaysAgo = min(max($spread + random_int(-5, 5), 0), self::HISTORY_DAYS);

            $start = $today->subDays($startDaysAgo);
            $days = $start->diffInDays($today) + 1;

            $totalViews = max((int) $article->views, 10);
            $totalShares = (int) round($totalViews * random_int(self::SHARE_RATIO_MIN, self::SHARE_RATIO_MAX) / 100);

            $viewsPerDay = $this->distribute($totalViews, $days);
            $sharesPerDay = $this->distribute($totalShares, $days);

            $rows = [];

            for ($i = 0; $i < $days; $i++) {
                $v = $viewsPerDay[$i];
                $s = $sharesPerDay[$i];

                if ($v === 0 && $s === 0) {
                    continue;
                }

                $rows[] = [
                    'article_id' => $article->id,
                    'date' => $start->addDays($i)->toDateString(),
                    'views' => $v,
                    'shares' => $s,
                ];
            }

            if ($rows !== []) {
                ArticleStat::upsert($rows, ['article_id', 'date'], ['views', 'shares']);
            }

            // Sinkronkan total kumulatif di tabel articles supaya konsisten
            // dengan jumlah rincian harian yang baru saja dibuat.
            if ((int) $article->shares !== $totalShares) {
                $article->forceFill(['shares' => $totalShares])->saveQuietly();
            }
        });
    }

    /**
     * Sebar $total ke $days hari mengikuti pola "ramai lalu mereda" (peluruhan
     * eksponensial + sedikit noise acak), lalu koreksi pembulatan supaya
     * jumlah akhirnya presis kembali ke $total.
     *
     * @return array<int, int>
     */
    private function distribute(int $total, int $days): array
    {
        if ($days <= 0) {
            return [];
        }

        if ($total <= 0) {
            return array_fill(0, $days, 0);
        }

        if ($days === 1) {
            return [$total];
        }

        $decay = max(self::DECAY_DAYS, (int) ($days / 4));
        $weights = [];

        for ($i = 0; $i < $days; $i++) {
            $noise = random_int(55, 145) / 100;
            $weights[] = max(exp(-$i / $decay) * $noise, 0.01);
        }

        $sum = array_sum($weights);
        $values = [];
        $assigned = 0;

        foreach ($weights as $i => $w) {
            $v = (int) floor($total * $w / $sum);
            $values[$i] = $v;
            $assigned += $v;
        }

        // Sisa pembulatan disebar ke hari-hari paling ramai (indeks awal)
        // supaya totalnya tetap presis sama dengan $total.
        $remainder = $total - $assigned;

        for ($i = 0; $remainder > 0; $i = ($i + 1) % $days) {
            $values[$i]++;
            $remainder--;
        }

        return $values;
    }
}
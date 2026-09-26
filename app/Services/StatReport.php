<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

/**
 * Menyusun Laporan Statistik: akumulasi views & share per berita
 * untuk satu minggu, satu bulan, atau satu tahun.
 *
 * Sumber datanya tabel article_stats (rekap harian). Hasil yang sama
 * dipakai halaman admin, export Excel, dan export PDF supaya angkanya
 * selalu identik.
 */
class StatReport
{
    public const PERIODS = ['week', 'month', 'year'];

    public const SORTS = ['views', 'shares', 'total'];

    private const PERIOD_NAMES = ['week' => 'Mingguan', 'month' => 'Bulanan', 'year' => 'Tahunan'];

    private const SORT_LABELS = ['views' => 'Views terbanyak', 'shares' => 'Share terbanyak', 'total' => 'Total terbanyak'];

    /**
     * Lengkapi filter yang kosong/tidak valid dengan nilai bawaan
     * (bulan berjalan, urut views).
     *
     * @param  array<string, mixed>  $input
     * @return array{period: string, date: string, month: int, year: int, category: ?string, sort: string}
     */
    public static function normalize(array $input): array
    {
        $today = CarbonImmutable::now(config('stats.timezone'));

        $period = $input['period'] ?? null;
        $sort = $input['sort'] ?? null;

        return [
            'period' => in_array($period, self::PERIODS, true) ? $period : 'month',
            'date' => ! empty($input['date']) ? (string) $input['date'] : $today->toDateString(),
            'month' => (int) (($input['month'] ?? null) ?: $today->month),
            'year' => (int) (($input['year'] ?? null) ?: $today->year),
            'category' => ! empty($input['category']) ? (string) $input['category'] : null,
            'sort' => in_array($sort, self::SORTS, true) ? $sort : 'views',
        ];
    }

    /**
     * Rentang tanggal (inklusif) sesuai filter.
     * Minggu berjalan Senin s/d Minggu.
     *
     * @param  array<string, mixed>  $f  hasil normalize()
     * @return array{0: CarbonImmutable, 1: CarbonImmutable}
     */
    public static function range(array $f): array
    {
        $tz = config('stats.timezone');

        if ($f['period'] === 'week') {
            $day = CarbonImmutable::parse($f['date'], $tz);

            return [
                $day->startOfWeek(CarbonInterface::MONDAY)->startOfDay(),
                $day->endOfWeek(CarbonInterface::SUNDAY)->startOfDay(),
            ];
        }

        if ($f['period'] === 'month') {
            $first = CarbonImmutable::create($f['year'], $f['month'], 1, 0, 0, 0, $tz);

            return [$first, $first->endOfMonth()->startOfDay()];
        }

        $first = CarbonImmutable::create($f['year'], 1, 1, 0, 0, 0, $tz);

        return [$first, $first->endOfYear()->startOfDay()];
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function build(array $filters): array
    {
        $tz = config('stats.timezone');
        $f = self::normalize($filters);
        [$start, $end] = self::range($f);

        $category = $f['category'] ? Category::where('slug', $f['category'])->first() : null;

        $rows = Article::query()
            ->join('article_stats', 'article_stats.article_id', '=', 'articles.id')
            ->whereBetween('article_stats.date', [$start->toDateString(), $end->toDateString()])
            ->when($category, fn ($q) => $q->where('articles.category_id', $category->id))
            ->select('articles.id', 'articles.category_id', 'articles.title', 'articles.slug')
            ->selectRaw('SUM(article_stats.views) as period_views')
            ->selectRaw('SUM(article_stats.shares) as period_shares')
            ->selectRaw('SUM(article_stats.views) + SUM(article_stats.shares) as period_total')
            ->groupBy('articles.id', 'articles.category_id', 'articles.title', 'articles.slug')
            ->orderByDesc('period_'.$f['sort'])
            ->orderBy('articles.title')
            ->with('category')
            ->get()
            ->each(function (Article $a) {
                $a->period_views = (int) $a->period_views;
                $a->period_shares = (int) $a->period_shares;
                $a->period_total = (int) $a->period_total;
            });

        $totals = [
            'views' => $rows->sum('period_views'),
            'shares' => $rows->sum('period_shares'),
            'total' => $rows->sum('period_total'),
            'articles' => $rows->count(),
        ];

        $first = DB::table('article_stats')->min('date');
        $thisYear = (int) CarbonImmutable::now($tz)->year;
        $firstYear = $first ? (int) substr((string) $first, 0, 4) : $thisYear;
        $years = collect(range(max($thisYear, $firstYear), min($thisYear, $firstYear)))
            ->push($f['year'])
            ->unique()
            ->sortDesc()
            ->values()
            ->all();

        return [
            'filters' => $f,
            'start' => $start,
            'end' => $end,
            'label' => $this->label($f, $start, $end),
            'periodName' => self::PERIOD_NAMES[$f['period']],
            'sortLabel' => self::SORT_LABELS[$f['sort']],
            'filename' => $this->filename($f, $start, $end),
            'category' => $category,
            'rows' => $rows,
            'totals' => $totals,
            'top' => $rows->sortByDesc('period_total')->first(),
            'trend' => $this->trend($f, $start, $end, $category),
            'firstDate' => $first,
            'firstDateLabel' => $first ? CarbonImmutable::parse($first, $tz)->locale('id')->translatedFormat('d F Y') : null,
            'years' => $years,
            'generatedAt' => CarbonImmutable::now($tz)->locale('id')->translatedFormat('d F Y, H:i').' '.$this->zoneAbbr($tz),
        ];
    }

    /**
     * Deret waktu untuk grafik: per hari (minggu/bulan) atau per bulan (tahun).
     * Hari/bulan tanpa data tetap ditampilkan sebagai 0.
     *
     * @return array{labels: array<int, string>, views: array<int, int>, shares: array<int, int>}
     */
    private function trend(array $f, CarbonImmutable $start, CarbonImmutable $end, ?Category $category): array
    {
        $daily = DB::table('article_stats')
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->when($category, fn ($q) => $q->whereIn('article_id', Article::where('category_id', $category->id)->select('id')))
            ->select('date')
            ->selectRaw('SUM(views) as v')
            ->selectRaw('SUM(shares) as s')
            ->groupBy('date')
            ->get()
            ->keyBy(fn ($r) => substr((string) $r->date, 0, 10));

        $labels = $views = $shares = [];

        if ($f['period'] === 'year') {
            for ($m = 1; $m <= 12; $m++) {
                $month = $start->setMonth($m);
                $prefix = $month->format('Y-m');
                $monthRows = $daily->filter(fn ($r, $day) => str_starts_with($day, $prefix));

                $labels[] = $month->locale('id')->translatedFormat('M');
                $views[] = (int) $monthRows->sum('v');
                $shares[] = (int) $monthRows->sum('s');
            }
        } else {
            for ($day = $start; $day->lte($end); $day = $day->addDay()) {
                $row = $daily->get($day->toDateString());

                $labels[] = $day->locale('id')->translatedFormat('d M');
                $views[] = (int) ($row->v ?? 0);
                $shares[] = (int) ($row->s ?? 0);
            }
        }

        return compact('labels', 'views', 'shares');
    }

    private function label(array $f, CarbonImmutable $start, CarbonImmutable $end): string
    {
        $fmt = fn (CarbonImmutable $d) => $d->locale('id')->translatedFormat('d F Y');

        return match ($f['period']) {
            'week' => 'Minggu '.$fmt($start).' – '.$fmt($end),
            'month' => $start->locale('id')->translatedFormat('F Y'),
            default => 'Tahun '.$start->year,
        };
    }

    private function filename(array $f, CarbonImmutable $start, CarbonImmutable $end): string
    {
        $suffix = match ($f['period']) {
            'week' => 'mingguan-'.$start->toDateString().'_sd_'.$end->toDateString(),
            'month' => 'bulanan-'.$start->format('Y-m'),
            default => 'tahunan-'.$start->year,
        };

        return 'laporan-statistik-'.$suffix;
    }

    private function zoneAbbr(string $tz): string
    {
        return match ($tz) {
            'Asia/Jakarta' => 'WIB',
            'Asia/Makassar' => 'WITA',
            'Asia/Jayapura' => 'WIT',
            default => $tz,
        };
    }
}

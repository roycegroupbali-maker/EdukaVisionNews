<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StatReportExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\StatReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class StatReportController extends Controller
{
    public function __construct(private StatReport $reports)
    {
    }

    /**
     * Halaman Laporan Statistik: filter minggu/bulan/tahun + tabel + grafik.
     */
    public function index(Request $request): View
    {
        $report = $this->reports->build($this->filters($request));
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.stats.index', compact('report', 'categories'));
    }

    public function exportExcel(Request $request): BinaryFileResponse|Response
    {
        $report = $this->reports->build($this->filters($request));

        return Excel::download(new StatReportExport($report), $report['filename'].'.xlsx');
    }

    public function exportPdf(Request $request): Response
    {
        $report = $this->reports->build($this->filters($request));

        return Pdf::loadView('admin.stats.pdf', ['report' => $report])
            ->setPaper('a4', 'portrait')
            ->download($report['filename'].'.pdf');
    }

    /**
     * @return array<string, mixed>
     */
    private function filters(Request $request): array
    {
        return $request->validate([
            'period' => ['nullable', Rule::in(StatReport::PERIODS)],
            'date' => ['nullable', 'date'],
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'category' => ['nullable', 'string', Rule::exists('categories', 'slug')],
            'sort' => ['nullable', Rule::in(StatReport::SORTS)],
        ]);
    }
}

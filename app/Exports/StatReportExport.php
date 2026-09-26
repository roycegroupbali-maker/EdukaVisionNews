<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export Excel Laporan Statistik. Menerima array hasil App\Services\StatReport::build().
 */
class StatReportExport implements FromArray, WithColumnFormatting, WithColumnWidths, WithStyles, WithTitle
{
    /** Baris (1-based) tempat judul kolom berada. */
    private const HEADING_ROW = 6;

    /** @param array<string, mixed> $report */
    public function __construct(private array $report)
    {
    }

    public function title(): string
    {
        return 'Statistik';
    }

    public function array(): array
    {
        $r = $this->report;

        $data = [
            ['Laporan Statistik Berita — EdukaVisionNews'],
            ['Periode', $r['periodName'].': '.$r['label']],
            ['Kategori', $r['category']?->name ?? 'Semua kategori'],
            ['Dicetak', $r['generatedAt']],
            [''],
            ['No', 'Judul Berita', 'Kategori', 'Views', 'Share', 'Total'],
        ];

        foreach ($r['rows'] as $i => $a) {
            $data[] = [
                $i + 1,
                $this->safe($a->title),
                $a->category->name ?? '-',
                $a->period_views,
                $a->period_shares,
                $a->period_total,
            ];
        }

        $data[] = ['', 'TOTAL ('.$r['totals']['articles'].' berita)', '', $r['totals']['views'], $r['totals']['shares'], $r['totals']['total']];

        return $data;
    }

    public function columnWidths(): array
    {
        return ['A' => 6, 'B' => 62, 'C' => 20, 'D' => 12, 'E' => 12, 'F' => 12];
    }

    public function columnFormats(): array
    {
        return ['D' => '#,##0', 'E' => '#,##0', 'F' => '#,##0'];
    }

    public function styles(Worksheet $sheet): array
    {
        $head = self::HEADING_ROW;
        $last = $head + $this->report['rows']->count() + 1;

        $sheet->mergeCells('A1:F1');
        foreach ([2, 3, 4] as $row) {
            $sheet->mergeCells("B{$row}:F{$row}");
        }

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            'A2:A4' => ['font' => ['bold' => true]],
            "A{$head}:F{$last}" => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D8D3C4']]],
            ],
            "A{$head}:F{$head}" => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D1B3A']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            "A{$last}:F{$last}" => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F1ECE1']],
            ],
        ];
    }

    /**
     * Cegah teks yang diawali = + - @ dibaca Excel sebagai rumus.
     */
    private function safe(string $text): string
    {
        return preg_match('/^[=+\-@]/', $text) ? "'".$text : $text;
    }
}

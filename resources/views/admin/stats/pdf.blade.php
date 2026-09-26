<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Statistik — EdukaVisionNews</title>
<style>
  @page { margin: 28px 32px; }
  * { box-sizing: border-box; }
  body { font-family: 'Helvetica', 'Arial', sans-serif; color: #0D1B3A; font-size: 11px; }
  h1 { font-size: 18px; margin: 0 0 4px; }
  .meta { color: #6B6558; font-size: 10.5px; margin-bottom: 2px; }
  .head { border-bottom: 2px solid #0D1B3A; padding-bottom: 10px; margin-bottom: 14px; }

  .stat-row { width: 100%; margin-bottom: 16px; }
  .stat-row td { width: 25%; padding: 10px 12px; border: 1px solid #e4ddcd; }
  .stat-row .label { font-size: 9px; text-transform: uppercase; letter-spacing: .06em; color: #8f8a7c; }
  .stat-row .value { font-size: 16px; font-weight: bold; margin-top: 3px; }

  table.data { width: 100%; border-collapse: collapse; }
  table.data th { background: #0D1B3A; color: #fff; text-align: left; padding: 7px 8px; font-size: 9.5px; text-transform: uppercase; letter-spacing: .04em; }
  table.data td { padding: 6px 8px; border-bottom: 1px solid #e4ddcd; font-size: 10.5px; }
  table.data tr:nth-child(even) td { background: #fbfaf7; }
  table.data tfoot td { font-weight: bold; background: #F1ECE1 !important; border-top: 1.5px solid #0D1B3A; }
  .num { text-align: right; }
  .footer { margin-top: 14px; font-size: 9.5px; color: #8f8a7c; }
</style>
</head>
<body>

  <div class="head">
    <h1>Laporan Statistik Berita — EdukaVisionNews</h1>
    <div class="meta">Periode {{ $report['periodName'] }}: {{ $report['label'] }}</div>
    <div class="meta">Kategori: {{ $report['category']->name ?? 'Semua kategori' }} &middot; Urutan: {{ $report['sortLabel'] }}</div>
    <div class="meta">Dicetak {{ $report['generatedAt'] }}</div>
  </div>

  <table class="stat-row">
    <tr>
      <td><div class="label">Total Views</div><div class="value">{{ number_format($report['totals']['views']) }}</div></td>
      <td><div class="label">Total Share</div><div class="value">{{ number_format($report['totals']['shares']) }}</div></td>
      <td><div class="label">Total Interaksi</div><div class="value">{{ number_format($report['totals']['total']) }}</div></td>
      <td><div class="label">Berita Aktif</div><div class="value">{{ number_format($report['totals']['articles']) }}</div></td>
    </tr>
  </table>

  <table class="data">
    <thead>
      <tr>
        <th style="width:28px;">No</th>
        <th>Judul Berita</th>
        <th style="width:100px;">Kategori</th>
        <th class="num" style="width:60px;">Views</th>
        <th class="num" style="width:60px;">Share</th>
        <th class="num" style="width:60px;">Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse($report['rows'] as $i => $a)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $a->title }}</td>
          <td>{{ $a->category->name ?? '-' }}</td>
          <td class="num">{{ number_format($a->period_views) }}</td>
          <td class="num">{{ number_format($a->period_shares) }}</td>
          <td class="num">{{ number_format($a->period_total) }}</td>
        </tr>
      @empty
        <tr><td colspan="6">Tidak ada aktivitas pada periode ini.</td></tr>
      @endforelse
    </tbody>
    @if($report['rows']->isNotEmpty())
      <tfoot>
        <tr>
          <td colspan="3">TOTAL ({{ $report['totals']['articles'] }} berita)</td>
          <td class="num">{{ number_format($report['totals']['views']) }}</td>
          <td class="num">{{ number_format($report['totals']['shares']) }}</td>
          <td class="num">{{ number_format($report['totals']['total']) }}</td>
        </tr>
      </tfoot>
    @endif
  </table>

  <div class="footer">EdukaVisionNews &middot; Laporan dibuat otomatis dari panel admin.</div>

</body>
</html>

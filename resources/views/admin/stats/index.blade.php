<x-admin-layout :page-title="'Laporan Statistik'" :page-subtitle="'Akumulasi views &amp; share per minggu, bulan, atau tahun'">

  @php
    $f = $report['filters'];
    $months = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
  @endphp

  <div class="filter-bar">
    <form method="GET" action="{{ route('admin.stats.index') }}" id="statFilterForm" style="display:flex; gap:10px; flex-wrap:wrap; flex:1; align-items:center;">
      <select name="period" onchange="statToggle(this.value); this.form.submit()">
        <option value="week" @selected($f['period']==='week')>Mingguan</option>
        <option value="month" @selected($f['period']==='month')>Bulanan</option>
        <option value="year" @selected($f['period']==='year')>Tahunan</option>
      </select>

      <input type="date" name="date" value="{{ $f['date'] }}" data-period="week"
             style="{{ $f['period']==='week' ? '' : 'display:none;' }}" onchange="this.form.submit()">

      <select name="month" data-period="month" style="{{ $f['period']==='month' ? '' : 'display:none;' }}" onchange="this.form.submit()">
        @foreach($months as $num => $name)
          <option value="{{ $num }}" @selected((int)$f['month']===(int)$num)>{{ $name }}</option>
        @endforeach
      </select>

      <select name="year" data-period="month year" style="{{ $f['period']==='week' ? 'display:none;' : '' }}" onchange="this.form.submit()">
        @foreach($report['years'] as $y)
          <option value="{{ $y }}" @selected((int)$f['year']===(int)$y)>{{ $y }}</option>
        @endforeach
      </select>

      <select name="category" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $c)
          <option value="{{ $c->slug }}" @selected($f['category'] === $c->slug)>{{ $c->name }}</option>
        @endforeach
      </select>

      <select name="sort" onchange="this.form.submit()">
        <option value="views" @selected($f['sort']==='views')>Urutkan: Views terbanyak</option>
        <option value="shares" @selected($f['sort']==='shares')>Urutkan: Share terbanyak</option>
        <option value="total" @selected($f['sort']==='total')>Urutkan: Total terbanyak</option>
      </select>

      @if(request()->anyFilled(['category']) || $f['sort'] !== 'views')
        <a href="{{ route('admin.stats.index', ['period' => $f['period']]) }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>

    <div style="display:flex; gap:8px;">
      <a href="{{ route('admin.stats.export.excel', request()->query()) }}" class="btn btn-ghost btn-sm">&#8681; Excel</a>
      <a href="{{ route('admin.stats.export.pdf', request()->query()) }}" class="btn btn-ghost btn-sm">&#8681; PDF</a>
    </div>
  </div>

  <script>
    function statToggle(period) {
      document.querySelectorAll('#statFilterForm [data-period]').forEach(function (el) {
        el.style.display = el.dataset.period.split(' ').includes(period) ? '' : 'none';
      });
    }
  </script>

  <div class="panel" style="padding:18px 22px; margin-bottom:22px;">
    <div style="font-family:'Fraunces', serif; font-size:17px; color:var(--ink);">{{ $report['periodName'] }} &middot; {{ $report['label'] }}</div>
    @if($report['category'])
      <div style="font-size:12.5px; color:var(--muted); margin-top:2px;">Kategori: {{ $report['category']->name }}</div>
    @endif
    @if($report['firstDateLabel'])
      <div style="font-size:11.5px; color:var(--muted-2); margin-top:6px;">Rekap harian tercatat sejak {{ $report['firstDateLabel'] }}. Data sebelum tanggal itu tidak dapat dipecah per periode.</div>
    @endif
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-label">Total Views</div>
      <div class="stat-value">{{ number_format($report['totals']['views']) }}</div>
      <div class="stat-note">Pada periode terpilih</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Share</div>
      <div class="stat-value">{{ number_format($report['totals']['shares']) }}</div>
      <div class="stat-note">Pada periode terpilih</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Aktif</div>
      <div class="stat-value">{{ number_format($report['totals']['articles']) }}</div>
      <div class="stat-note">Punya minimal 1 views/share</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Teratas</div>
      <div class="stat-value" style="font-size:15px; line-height:1.4;">{{ $report['top']->title ?? '—' }}</div>
      <div class="stat-note">@if($report['top']){{ number_format($report['top']->period_total) }} total interaksi @else Belum ada data @endif</div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head"><h2>Tren {{ $report['filters']['period'] === 'year' ? 'per Bulan' : 'per Hari' }}</h2></div>
    <div class="panel-body">
      <div style="position:relative; height:280px;">
        <canvas id="chartStatTrend"></canvas>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <h2>Akumulasi per Berita</h2>
      <span style="font-size:12px; color:var(--muted-2);">{{ $report['sortLabel'] }}</span>
    </div>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Views</th>
            <th>Share</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @forelse($report['rows'] as $a)
            <tr>
              <td class="title-cell"><a href="{{ route('admin.articles.edit', $a) }}">{{ $a->title }}</a></td>
              <td>{{ $a->category->name ?? '—' }}</td>
              <td>{{ number_format($a->period_views) }}</td>
              <td>{{ number_format($a->period_shares) }}</td>
              <td>{{ number_format($a->period_total) }}</td>
            </tr>
          @empty
            <tr><td colspan="5"><div class="empty-state"><h3>Belum ada aktivitas</h3><p>Tidak ada views atau share yang tercatat pada periode ini.</p></div></td></tr>
          @endforelse
        </tbody>
        @if($report['rows']->isNotEmpty())
          <tfoot>
            <tr style="font-weight:700; background:var(--paper-alt);">
              <td colspan="2">Total ({{ $report['totals']['articles'] }} berita)</td>
              <td>{{ number_format($report['totals']['views']) }}</td>
              <td>{{ number_format($report['totals']['shares']) }}</td>
              <td>{{ number_format($report['totals']['total']) }}</td>
            </tr>
          </tfoot>
        @endif
      </table>
    </div>
  </div>

  <script type="application/json" id="stat-trend-data">
    {!! json_encode([
      'labels' => $report['trend']['labels'],
      'views' => $report['trend']['views'],
      'shares' => $report['trend']['shares'],
    ]) !!}
  </script>
  @vite(['resources/js/admin/stat-report-chart.js'])

</x-admin-layout>

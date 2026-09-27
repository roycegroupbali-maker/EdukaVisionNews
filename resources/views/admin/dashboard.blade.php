<x-admin-layout :page-title="'Dashboard'" :page-subtitle="'Ringkasan konten dan iklan EdukaVisionNews'">

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-label">Total Berita</div>
      <div class="stat-value">{{ $totalArticles }}</div>
      <div class="stat-note">{{ $publishedArticles }} tayang · {{ $draftArticles }} draf</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Tayang</div>
      <div class="stat-value">{{ $publishedArticles }}</div>
      <div class="stat-note">Sudah bisa dibaca publik</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Iklan</div>
      <div class="stat-value">{{ $totalAds }}</div>
      <div class="stat-note">{{ $activeAds }} sedang aktif tayang</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Kategori</div>
      <div class="stat-value">{{ $articlesPerCategory->count() }}</div>
      <div class="stat-note">Rubrik yang tersedia</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Pengajuan Berita</div>
      <div class="stat-value">{{ $pendingSubmissions }}</div>
      <div class="stat-note">
        @if($pendingSubmissions > 0)
          <a href="{{ route('admin.news-submissions.index') }}">Menunggu ditinjau &rarr;</a>
        @else
          Tidak ada yang menunggu
        @endif
      </div>
    </div>
    @if(auth()->user()->hasPermission('articles.publish'))
      <div class="stat-card">
        <div class="stat-label">Berita Menunggu Tinjauan</div>
        <div class="stat-value">{{ $pendingReview }}</div>
        <div class="stat-note">
          @if($pendingReview > 0)
            <a href="{{ route('admin.articles.index', ['status' => 'pending']) }}">Tinjau sekarang &rarr;</a>
          @else
            Tidak ada pengajuan wartawan
          @endif
        </div>
      </div>
    @endif
  </div>

  <div class="panel" style="margin-bottom:22px;">
    <div class="panel-head"><h2>Grafik Views &amp; Shares per Kategori</h2></div>
    <div class="panel-body">
      <div style="position:relative; height:280px;">
        <canvas id="chartViewsPerCategory"></canvas>
      </div>
    </div>
  </div>

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head">
          <h2>Berita Terbaru Diinput</h2>
          @if(auth()->user()->hasPermission('articles.create'))
            <a href="{{ route('admin.articles.create') }}" class="btn btn-accent btn-sm">+ Tulis Berita</a>
          @endif
        </div>
        <div class="panel-body">
          @forelse($latestArticles as $a)
            <div class="category-bar-row" style="align-items:flex-start;">
              <div style="flex:1;">
                <a href="{{ route('admin.articles.edit', $a) }}" style="font-weight:600; color:var(--ink);">{{ $a->title }}</a>
                <div style="font-size:12px; color:var(--muted-2); margin-top:2px;">
                  {{ $a->category->name ?? '—' }} · {{ $a->created_at->translatedFormat('d M Y, H:i') }}
                  · <span class="badge {{ $a->status_badge_class }}">{{ $a->status_label }}</span>
                </div>
              </div>
            </div>
          @empty
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada berita.</p>
          @endforelse
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Grafik Berita Paling Banyak Dibaca</h2></div>
        <div class="panel-body">
          <div style="position:relative; height:260px;">
            <canvas id="chartMostViewed"></canvas>
          </div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Berita Paling Banyak Dibaca</h2></div>
        <div class="panel-body">
          @php $maxViews = max(1, $mostViewed->max('views')); @endphp
          @forelse($mostViewed as $a)
            <div class="category-bar-row">
              <div class="cbr-name" style="flex:0 0 40%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                <a href="{{ route('admin.articles.edit', $a) }}" style="font-weight:600; color:var(--ink);">{{ $a->title }}</a>
              </div>
              <div class="category-bar-track">
                <div class="category-bar-fill" style="width:{{ max(6, ($a->views / $maxViews) * 100) }}%; background:var(--pulse);"></div>
              </div>
              <div class="category-bar-count" style="width:56px;">{{ number_format($a->views) }}</div>
            </div>
          @empty
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada data.</p>
          @endforelse
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Berita Paling Banyak Dibagikan</h2></div>
        <div class="panel-body">
          @php $maxShares = max(1, $mostShared->max('shares')); @endphp
          @forelse($mostShared as $a)
            <div class="category-bar-row">
              <div class="cbr-name" style="flex:0 0 40%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                <a href="{{ route('admin.articles.edit', $a) }}" style="font-weight:600; color:var(--ink);">{{ $a->title }}</a>
              </div>
              <div class="category-bar-track">
                <div class="category-bar-fill" style="width:{{ max(6, ($a->shares / $maxShares) * 100) }}%; background:var(--gold);"></div>
              </div>
              <div class="category-bar-count" style="width:56px;">{{ number_format($a->shares) }}</div>
            </div>
          @empty
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada data.</p>
          @endforelse
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="panel">
        <div class="panel-head"><h2>Berita per Kategori</h2></div>
        <div class="panel-body">
          @php $max = max(1, $articlesPerCategory->max('articles_count')); @endphp
          @foreach($articlesPerCategory as $cat)
            <div class="category-bar-row">
              <div class="cbr-name">{{ $cat->name }}</div>
              <div class="category-bar-track">
                <div class="category-bar-fill" style="width:{{ $cat->articles_count > 0 ? max(6, ($cat->articles_count / $max) * 100) : 0 }}%;"></div>
              </div>
              <div class="category-bar-count">{{ $cat->articles_count }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Total Views per Kategori</h2></div>
        <div class="panel-body">
          @php $maxCatViews = max(1, $articlesPerCategory->max('articles_sum_views')); @endphp
          @foreach($articlesPerCategory as $cat)
            <div class="category-bar-row">
              <div class="cbr-name">{{ $cat->name }}</div>
              <div class="category-bar-track">
                <div class="category-bar-fill" style="width:{{ ($cat->articles_sum_views ?? 0) > 0 ? max(6, ($cat->articles_sum_views / $maxCatViews) * 100) : 0 }}%; background:var(--pulse);"></div>
              </div>
              <div class="category-bar-count" style="width:56px;">{{ number_format($cat->articles_sum_views ?? 0) }}</div>
            </div>
          @endforeach
          <p style="font-size:11.5px; color:var(--muted-2); margin-top:10px;">Total dibaca dari seluruh berita di tiap kategori, dihitung real-time dari kunjungan pembaca.</p>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Komposisi Views per Kategori</h2></div>
        <div class="panel-body">
          <div style="position:relative; height:240px;">
            <canvas id="chartCategoryDonut"></canvas>
          </div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Aksi Cepat</h2></div>
        <div class="panel-body" style="display:flex; flex-direction:column; gap:10px; padding-bottom:20px;">
          @if(auth()->user()->hasPermission('articles.create'))
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-block">+ Tulis Berita Baru</a>
          @endif
          @if(auth()->user()->hasPermission('ads.manage'))
            <a href="{{ route('admin.ads.create') }}" class="btn btn-ghost btn-block">+ Upload Iklan Baru</a>
          @endif
          @if(auth()->user()->hasPermission('categories.manage'))
            <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-block">Kelola Kategori</a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <script type="application/json" id="dashboard-chart-data">
    {!! json_encode([
      'categoryLabels' => $articlesPerCategory->pluck('name'),
      'categoryViews'  => $articlesPerCategory->pluck('articles_sum_views')->map(fn ($v) => (int) ($v ?? 0)),
      'categoryShares' => $articlesPerCategory->pluck('articles_sum_shares')->map(fn ($v) => (int) ($v ?? 0)),
      'mostViewedTitles' => $mostViewed->pluck('title'),
      'mostViewedViews'  => $mostViewed->pluck('views'),
    ]) !!}
  </script>
  @vite(['resources/js/admin/dashboard-charts.js'])

</x-admin-layout>
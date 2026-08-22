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
  </div>

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head">
          <h2>Berita Terbaru Diinput</h2>
          <a href="{{ route('admin.articles.create') }}" class="btn btn-accent btn-sm">+ Tulis Berita</a>
        </div>
        <div class="panel-body">
          @forelse($latestArticles as $a)
            <div class="category-bar-row" style="align-items:flex-start;">
              <div style="flex:1;">
                <a href="{{ route('admin.articles.edit', $a) }}" style="font-weight:600; color:var(--ink);">{{ $a->title }}</a>
                <div style="font-size:12px; color:var(--muted-2); margin-top:2px;">
                  {{ $a->category->name ?? '—' }} · {{ $a->created_at->translatedFormat('d M Y, H:i') }}
                  @if(!$a->published_at) · <span class="badge badge-gray">Draf</span> @endif
                </div>
              </div>
            </div>
          @empty
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada berita.</p>
          @endforelse
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Berita Paling Banyak Dibaca</h2></div>
        <div class="panel-body">
          @forelse($mostViewed as $a)
            <div class="category-bar-row">
              <div style="flex:1;">
                <a href="{{ route('admin.articles.edit', $a) }}" style="font-weight:600; color:var(--ink);">{{ $a->title }}</a>
              </div>
              <div class="cbr-count" style="font-size:12.5px; color:var(--muted);">{{ number_format($a->views) }} views</div>
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
        <div class="panel-head"><h2>Aksi Cepat</h2></div>
        <div class="panel-body" style="display:flex; flex-direction:column; gap:10px; padding-bottom:20px;">
          <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-block">+ Tulis Berita Baru</a>
          <a href="{{ route('admin.ads.create') }}" class="btn btn-ghost btn-block">+ Upload Iklan Baru</a>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-block">Kelola Kategori</a>
        </div>
      </div>
    </div>
  </div>

</x-admin-layout>

@include('partials.header', ['pageTitle' => 'EdukaVisionNews — Denyut Kabar Hari Ini'])

<!-- ============ LEADERBOARD AD ============ -->
<div class="section-band">
  <div class="wrap">
    @include('partials.ad-slot', ['slot' => 'leaderboard'])
  </div>
</div>

<!-- ============ HERO ============ -->
@if($hero)
<section class="hero section-band">
  <div class="wrap hero-grid">
    <a href="{{ route('article.show', $hero->slug) }}" class="feature-card">
      <div class="feature-art">
        <button class="bookmark-btn" aria-label="Simpan artikel" onclick="event.preventDefault()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M6 3a2 2 0 0 0-2 2v16l8-5 8 5V5a2 2 0 0 0-2-2H6z"/></svg>
        </button>
        @include('partials.art', ['article' => $hero, 'viewbox' => '0 0 640 400'])
      </div>
      <span class="tag {{ $hero->category->tag_class }}">{{ $hero->subcategory ?? $hero->category->name }}</span>
      <h1 class="feature-headline display">{{ $hero->title }}</h1>
      <p class="feature-dek">{{ $hero->excerpt }}</p>
      <span class="byline">{{ strtoupper($hero->author) }} · {{ $hero->read_minutes }} MENIT BACA</span>
    </a>

    <div class="side-list">
      @foreach($sideList as $s)
        @include('partials.card', ['article' => $s, 'variant' => 'side'])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H480 L505 6 L525 40 L545 23 H1240"/>
  <circle cx="525" cy="23" r="4"/>
</svg>

<!-- ============ TRENDING + SIDEBAR AD ============ -->
<section class="section-band alt">
  <div class="wrap trend-ad-grid">
    <div class="trend-widget">
      <div class="trend-widget-head">
        <h3><span class="bar"></span> Sedang Tren</h3>
      </div>
      <div class="trend-tabs">
        <button class="trend-tab active" data-panel="trendPopuler">Terpopuler</button>
        <button class="trend-tab" data-panel="trendTerbaru">Terbaru</button>
      </div>
      <div class="trend-panel active" id="trendPopuler">
        @foreach($trending as $i => $t)
          <a href="{{ route('article.show', $t->slug) }}" class="trend-item"><span class="trend-rank">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><span class="trend-title">{{ $t->title }}</span></a>
        @endforeach
      </div>
      <div class="trend-panel" id="trendTerbaru">
        @foreach($latest as $i => $t)
          <a href="{{ route('article.show', $t->slug) }}" class="trend-item"><span class="trend-rank">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><span class="trend-title">{{ $t->title }}</span></a>
        @endforeach
      </div>
    </div>

    @include('partials.ad-slot', ['slot' => 'rectangle'])
  </div>
</section>

@php
    $berita = $sections->get('berita', collect());
    $dunia = $sections->get('dunia', collect());
    $bisnis = $sections->get('bisnis', collect());
    $olahraga = $sections->get('olahraga', collect());
    $lifestyle = $sections->get('lifestyle', collect());
    $edukasi = $sections->get('edukasi', collect());
    $resep = $sections->get('resep', collect());
@endphp

<!-- ============ BERITA TERKINI ============ -->
@if($berita->count())
<section class="section-band" id="berita">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Berita Terkini</h2>
      <a href="{{ route('category.show', 'berita') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4">
      @foreach($berita as $a)
        @include('partials.card', ['article' => $a])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ DUNIA / INTERNASIONAL ============ -->
@if($dunia->count())
<section class="section-band alt" id="dunia">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--violet);"></span> Dunia</h2>
      <a href="{{ route('category.show', 'dunia') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="world-strip">
      @foreach($dunia->take(3) as $i => $a)
        @include('partials.card', ['article' => $a, 'variant' => $i === 0 ? 'big' : 'default'])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H520 L540 8 L558 38 L572 15 H1240"/>
  <circle cx="558" cy="38" r="4"/>
</svg>

<!-- ============ BISNIS & EKONOMI ============ -->
@if($bisnis->count())
<section class="section-band" id="bisnis">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--ink);"></span> Ekonomi &amp; Bisnis</h2>
      <a href="{{ route('category.show', 'bisnis') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4 grid-4-foot">
      @foreach($bisnis->take(4) as $a)
        @include('partials.card', ['article' => $a])
      @endforeach
    </div>

    @include('partials.ad-slot', ['slot' => 'midpage'])
  </div>
</section>
@endif

<!-- ============ OLAHRAGA ============ -->
@if($olahraga->count())
<section class="section-band alt" id="olahraga">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--navy2);"></span> Olahraga</h2>
      <a href="{{ route('category.show', 'olahraga') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>

    <div class="grid-4 grid-4-foot">
      @foreach($olahraga->take(4) as $a)
        @include('partials.card', ['article' => $a])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ LIFESTYLE ============ -->
@if($lifestyle->count())
<section class="section-band" id="lifestyle">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--teal);"></span> Lifestyle</h2>
      <a href="{{ route('category.show', 'lifestyle') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    @php $lsChunks = $lifestyle->skip(1)->take(6)->chunk(3); @endphp
    <div class="split-3">
      @if($lifestyle->first())
        @include('partials.card', ['article' => $lifestyle->first(), 'variant' => 'big'])
      @endif
      @foreach($lsChunks as $chunk)
        <div class="stack-col">
          @foreach($chunk as $a)
            @include('partials.card', ['article' => $a, 'variant' => 'stacked'])
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ EDUKASI ============ -->
@if($edukasi->count())
<section class="section-band alt" id="edukasi">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--gold-deep);"></span> Edukasi</h2>
      <a href="{{ route('category.show', 'edukasi') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4 grid-4-foot">
      @foreach($edukasi->take(4) as $a)
        @include('partials.card', ['article' => $a])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H340 L360 8 L378 38 L392 15 L410 23 H1240"/>
  <circle cx="378" cy="38" r="4"/>
</svg>

<!-- ============ RESEP MASAKAN ============ -->
@if($resep->count())
<section class="section-band" id="resep">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--rust);"></span> Resep Masakan</h2>
      <a href="{{ route('category.show', 'resep') }}" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>

    @if($resep->first())
      @include('partials.recipe-card', ['article' => $resep->first(), 'variant' => 'feature'])
    @endif

    <div class="grid-3-recipe">
      @foreach($resep->skip(1)->take(3) as $a)
        @include('partials.recipe-card', ['article' => $a])
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ JAJAK PENDAPAT ============ -->
<section class="section-band alt poll-section">
  <div class="wrap">
    <div class="poll-widget">
      <span class="tag">Jajak Pendapat Pembaca</span>
      <h3 class="poll-question">Topik apa yang paling ingin kamu baca lebih banyak minggu ini?</h3>
      <button class="poll-option" data-opt="opt1">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Perkembangan ekonomi &amp; bisnis lokal</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt2">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Pendidikan &amp; beasiswa</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt3">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Resep &amp; kuliner Nusantara</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt4">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Olahraga nasional</span><span class="poll-pct">0%</span></div>
      </button>
      <div class="poll-meta">
        <span id="pollNote">Pilih satu jawaban untuk melihat hasil sementara.</span>
        <span><span id="pollTotal">1.284</span> suara</span>
      </div>
    </div>
  </div>
</section>

@include('partials.footer')

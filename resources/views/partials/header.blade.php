<!DOCTYPE html>
<html lang="id">
<head>
@php
    // ============ SEO — nilai default & fallback ============
    // Semua nilai di bawah bisa dioverride per halaman lewat @include('partials.header', [...]).
    $seoTitle       = $pageTitle ?? 'EdukaVisionNews — Denyut Kabar Hari Ini';
    $seoDescription = $pageDescription ?? 'Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.';
    $seoType        = $ogType ?? 'website';
    $seoCanonical   = $canonical ?? url()->current();
    $seoRobots      = $robots ?? 'index, follow, max-image-preview:large';
    $seoImage       = $ogImage ?? asset('images/logo.png');
    $seoKeywords    = $ogKeywords ?? null;
@endphp
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
@if($seoKeywords)
<meta name="keywords" content="{{ $seoKeywords }}">
@endif
<meta name="robots" content="{{ $seoRobots }}">
<meta name="googlebot" content="{{ $seoRobots }}">
<meta name="author" content="{{ $ogAuthor ?? 'Redaksi EdukaVisionNews' }}">
<meta name="theme-color" content="#0D1B3A">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="canonical" href="{{ $seoCanonical }}">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="apple-touch-icon" href="{{ asset('images/logo-icon.png') }}">

{{-- Open Graph / Twitter Card, dipakai saat artikel dibagikan ke media sosial --}}
<meta property="og:site_name" content="EdukaVisionNews">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:locale" content="id_ID">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:alt" content="{{ $ogImageAlt ?? $seoTitle }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

@if($seoType === 'article')
{{-- Meta Open Graph khusus artikel berita, membantu Google News & crawler sosial --}}
<meta property="article:published_time" content="{{ $ogPublishedTime ?? '' }}">
<meta property="article:modified_time" content="{{ $ogModifiedTime ?? $ogPublishedTime ?? '' }}">
<meta property="article:author" content="{{ $ogAuthor ?? 'Redaksi EdukaVisionNews' }}">
<meta property="article:section" content="{{ $ogSection ?? '' }}">
@foreach(($ogTags ?? []) as $ogTag)
<meta property="article:tag" content="{{ $ogTag }}">
@endforeach
@endif

{{-- JSON-LD: identitas organisasi + kotak pencarian situs (sitewide, dipakai Google untuk Sitelinks Search Box & Knowledge Panel) --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'NewsMediaOrganization',
            '@id' => url('/#organization'),
            'name' => 'EdukaVisionNews',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
            'sameAs' => [],
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => 'EdukaVisionNews',
            'url' => url('/'),
            'publisher' => ['@id' => url('/#organization')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/cari') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

@isset($breadcrumbs)
{{-- JSON-LD: breadcrumb, membantu Google menampilkan jejak navigasi di hasil pencarian --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($breadcrumbs)->values()->map(fn ($crumb, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['name'],
        'item' => $crumb['url'],
    ])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endisset

<link rel="preconnect" href="https://fonts.googleapis.com">
{{-- Font Google (Fraunces, Inter, IBM Plex Mono) sudah di-import lewat resources/css/site.css --}}
@vite(['resources/css/app.css', 'resources/css/site.css', 'resources/js/site.js'])

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
</head>
<body>
@include('partials.accessibility-widget')
<!-- ============ READING PROGRESS ============ -->
<div class="read-progress"><div class="read-progress-bar" id="readProgress"></div></div>

<!-- ============ TOP UTILITY BAR ============ -->
<div class="topbar">
  <div class="wrap">
    <div class="pulse-dot"><i></i> {{ now()->translatedFormat('l, d F Y') }} · Denpasar, 29°C Cerah Berawan · <span class="live-clock" id="liveClock">--:--:--</span> <span id="liveClockZone">WITA</span></div>
    <div class="topbar-links">
      <a href="{{ route('pages.redaksi') }}">Redaksi berita</a>
      <a href="{{ route('pages.pedoman') }}">Pedoman Media Siber</a>
      <a href="{{ route('pages.about') }}">Tentang kami</a>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="main">
  <div class="wrap nav-row">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/logo-icon.png') }}" alt="EdukaVisionNews" class="logo-mark-img">
      <span class="logo-text">Eduka<span class="accent">Vision</span>News<sub>Denyut Kabar Hari Ini</sub></span>
    </a>
    <nav class="primary">
      @foreach(($categories ?? []) as $navCat)
        <a href="{{ route('category.show', $navCat->slug) }}" @class(['active' => (isset($category) && $category->id === $navCat->id)])>{{ $navCat->name }}</a>
      @endforeach
    </nav>
    <div class="nav-actions">
      <button class="icon-btn" aria-label="Ganti mode gelap/terang" id="themeToggle" title="Mode gelap/terang">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <button class="icon-btn" aria-label="Cari artikel" id="searchBtn" title="Cari artikel">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      </button>
      <a href="{{ route('news-submission.create') }}" class="btn-subscribe">Permohonan Berita</a>
    </div>
  </div>
</header>

<!-- ============ SEARCH OVERLAY ============ -->
<div class="search-overlay" id="searchOverlay">
  <div class="search-panel" role="dialog" aria-label="Pencarian artikel">
    <form class="search-panel-head" action="{{ route('search') }}" method="GET">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      <input type="text" name="q" id="searchInput" placeholder="Cari judul berita, resep, atau topik…" autocomplete="off" value="{{ $query ?? '' }}">
      <button type="button" class="search-close" id="searchClose" aria-label="Tutup pencarian">✕</button>
    </form>
    <div class="search-results" id="searchResults">
      <p class="search-hint">Ketik kata kunci lalu tekan Enter untuk mencari di seluruh artikel.</p>
    </div>
  </div>
</div>

<!-- ============ BREAKING TICKER ============ -->
@if(!empty($latest) && count($latest))
<div class="ticker">
  <div class="wrap">
    <div class="ticker-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/></svg>
      TERKINI
    </div>
    <div class="ticker-track">
      <div class="ticker-move">
        @foreach($latest as $t)
          @php
            $tickerHref = $t->url ?? ($t->slug ? route('article.show', $t->slug) : null);
          @endphp
          <span>
            @if($tickerHref)
              <a href="{{ $tickerHref }}">{{ $t->title }}</a>
            @else
              {{ $t->title }}
            @endif
          </span>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif

<!-- ============ CATEGORY STRIP ============ -->
<div class="catstrip">
  <div class="wrap">
    @foreach(($categories ?? []) as $navCat)
      <a href="{{ route('category.show', $navCat->slug) }}" @class(['active' => (isset($category) && $category->id === $navCat->id)])>{{ $navCat->name }}</a>
    @endforeach
  </div>
</div>
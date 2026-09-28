<!DOCTYPE html>
<html lang="id">
<head>
<?php
    // ============ SEO — nilai default & fallback ============
    // Semua nilai di bawah bisa dioverride per halaman lewat @include('partials.header', [...]).
    $seoTitle       = $pageTitle ?? 'EdukaVisionNews — Denyut Kabar Hari Ini';
    $seoDescription = $pageDescription ?? 'Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.';
    $seoType        = $ogType ?? 'website';
    $seoCanonical   = $canonical ?? url()->current();
    $seoRobots      = $robots ?? 'index, follow, max-image-preview:large';
    $seoImage       = $ogImage ?? asset('images/logo.png');
    $seoKeywords    = $ogKeywords ?? null;
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($seoTitle); ?></title>
<meta name="description" content="<?php echo e($seoDescription); ?>">
<?php if($seoKeywords): ?>
<meta name="keywords" content="<?php echo e($seoKeywords); ?>">
<?php endif; ?>
<meta name="robots" content="<?php echo e($seoRobots); ?>">
<meta name="googlebot" content="<?php echo e($seoRobots); ?>">
<meta name="author" content="<?php echo e($ogAuthor ?? 'Redaksi EdukaVisionNews'); ?>">
<meta name="theme-color" content="#0D1B3A">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="canonical" href="<?php echo e($seoCanonical); ?>">
<link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" sizes="any">
<link rel="apple-touch-icon" href="<?php echo e(asset('images/logo-icon.png')); ?>">


<meta property="og:site_name" content="EdukaVisionNews">
<meta property="og:type" content="<?php echo e($seoType); ?>">
<meta property="og:locale" content="id_ID">
<meta property="og:title" content="<?php echo e($seoTitle); ?>">
<meta property="og:description" content="<?php echo e($seoDescription); ?>">
<meta property="og:url" content="<?php echo e($seoCanonical); ?>">
<meta property="og:image" content="<?php echo e($seoImage); ?>">
<meta property="og:image:alt" content="<?php echo e($ogImageAlt ?? $seoTitle); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
<meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
<meta name="twitter:image" content="<?php echo e($seoImage); ?>">

<?php if($seoType === 'article'): ?>

<meta property="article:published_time" content="<?php echo e($ogPublishedTime ?? ''); ?>">
<meta property="article:modified_time" content="<?php echo e($ogModifiedTime ?? $ogPublishedTime ?? ''); ?>">
<meta property="article:author" content="<?php echo e($ogAuthor ?? 'Redaksi EdukaVisionNews'); ?>">
<meta property="article:section" content="<?php echo e($ogSection ?? ''); ?>">
<?php $__currentLoopData = ($ogTags ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ogTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<meta property="article:tag" content="<?php echo e($ogTag); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
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
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>

</script>

<?php if(isset($breadcrumbs)): ?>

<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($breadcrumbs)->values()->map(fn ($crumb, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['name'],
        'item' => $crumb['url'],
    ])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>

</script>
<?php endif; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/site.css', 'resources/js/site.js']); ?>

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
</head>
<body>
<?php echo $__env->make('partials.accessibility-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- ============ READING PROGRESS ============ -->
<div class="read-progress"><div class="read-progress-bar" id="readProgress"></div></div>

<!-- ============ TOP UTILITY BAR ============ -->
<div class="topbar">
  <div class="wrap">
    <div class="pulse-dot"><i></i> <?php echo e(now()->translatedFormat('l, d F Y')); ?> · Denpasar, 29°C Cerah Berawan · <span class="live-clock" id="liveClock">--:--:--</span> <span id="liveClockZone">WITA</span></div>
    <div class="topbar-links">
      <a href="<?php echo e(route('pages.redaksi')); ?>">Redaksi berita</a>
      <a href="<?php echo e(route('pages.pedoman')); ?>">Pedoman Media Siber</a>
      <a href="<?php echo e(route('pages.about')); ?>">Tentang kami</a>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="main">
  <div class="wrap nav-row">
    <a href="<?php echo e(route('home')); ?>" class="logo">
      <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="EdukaVisionNews" class="logo-mark-img">
      <span class="logo-text">Eduka<span class="accent">Vision</span>News<sub>Denyut Kabar Hari Ini</sub></span>
    </a>
    <nav class="primary">
      <?php $__currentLoopData = ($categories ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('category.show', $navCat->slug)); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => (isset($category) && $category->id === $navCat->id)]); ?>"><?php echo e($navCat->name); ?></a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
    <div class="nav-actions">
      <button class="icon-btn" aria-label="Ganti mode gelap/terang" id="themeToggle" title="Mode gelap/terang">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <button class="icon-btn" aria-label="Cari artikel" id="searchBtn" title="Cari artikel">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      </button>
      <a href="<?php echo e(route('news-submission.create')); ?>" class="btn-subscribe">Permohonan Berita</a>
    </div>
  </div>
</header>

<!-- ============ SEARCH OVERLAY ============ -->
<div class="search-overlay" id="searchOverlay">
  <div class="search-panel" role="dialog" aria-label="Pencarian artikel">
    <form class="search-panel-head" action="<?php echo e(route('search')); ?>" method="GET">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      <input type="text" name="q" id="searchInput" placeholder="Cari judul berita, resep, atau topik…" autocomplete="off" value="<?php echo e($query ?? ''); ?>">
      <button type="button" class="search-close" id="searchClose" aria-label="Tutup pencarian">✕</button>
    </form>
    <div class="search-results" id="searchResults">
      <p class="search-hint">Ketik kata kunci lalu tekan Enter untuk mencari di seluruh artikel.</p>
    </div>
  </div>
</div>

<!-- ============ BREAKING TICKER ============ -->
<?php if(!empty($latest) && count($latest)): ?>
<div class="ticker">
  <div class="wrap">
    <div class="ticker-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h8l-1 8 10-12h-8l1-8z"/></svg>
      TERKINI
    </div>
    <div class="ticker-track">
      <div class="ticker-move">
        <?php $__currentLoopData = $latest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $tickerHref = $t->url ?? ($t->slug ? route('article.show', $t->slug) : null);
          ?>
          <span>
            <?php if($tickerHref): ?>
              <a href="<?php echo e($tickerHref); ?>"><?php echo e($t->title); ?></a>
            <?php else: ?>
              <?php echo e($t->title); ?>

            <?php endif; ?>
          </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ============ CATEGORY STRIP ============ -->
<div class="catstrip">
  <div class="wrap">
    <?php $__currentLoopData = ($categories ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route('category.show', $navCat->slug)); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => (isset($category) && $category->id === $navCat->id)]); ?>"><?php echo e($navCat->name); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/header.blade.php ENDPATH**/ ?>
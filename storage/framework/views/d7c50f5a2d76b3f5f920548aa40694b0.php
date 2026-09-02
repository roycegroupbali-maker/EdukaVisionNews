<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($pageTitle ?? 'EdukaVisionNews — Denyut Kabar Hari Ini'); ?></title>
<meta name="description" content="<?php echo e($pageDescription ?? 'Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.'); ?>">
<meta name="theme-color" content="#0D1B3A">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="canonical" href="<?php echo e(url()->current()); ?>">
<link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" sizes="any">


<meta property="og:site_name" content="EdukaVisionNews">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo e($pageTitle ?? 'EdukaVisionNews — Denyut Kabar Hari Ini'); ?>">
<meta property="og:description" content="<?php echo e($pageDescription ?? 'Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.'); ?>">
<meta property="og:url" content="<?php echo e(url()->current()); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($pageTitle ?? 'EdukaVisionNews — Denyut Kabar Hari Ini'); ?>">
<meta name="twitter:description" content="<?php echo e($pageDescription ?? 'Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.'); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/site.css', 'resources/js/site.js']); ?>
</head>
<body>
<?php echo $__env->make('partials.accessibility-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- ============ READING PROGRESS ============ -->
<div class="read-progress"><div class="read-progress-bar" id="readProgress"></div></div>

<!-- ============ TOP UTILITY BAR ============ -->
<div class="topbar">
  <div class="wrap">
    <div class="pulse-dot"><i></i> <?php echo e(now()->translatedFormat('l, d F Y')); ?> · Denpasar, 29°C Cerah Berawan · <span class="live-clock" id="liveClock">--:--:--</span> WITA</div>
    <div class="topbar-links">
      <a href="<?php echo e(route('pages.redaksi')); ?>">Redaksi berita</a>
      <a href="<?php echo e(route('pages.pedoman')); ?>">Pedoman Media Siber</a>
      <a>Indeks</a>
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
          <span><a href="<?php echo e(route('article.show', $t->slug)); ?>"><?php echo e($t->title); ?></a></span>
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
</div>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/header.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($pageTitle ?? 'Panel Admin'); ?> — EdukaVisionNews</title>
<meta name="robots" content="noindex, nofollow">
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin/admin.css', 'resources/js/admin/admin.js']); ?>
</head>
<body class="admin-body">

<div class="admin-shell">

  <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>

  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-brand">
      <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="EdukaVisionNews" class="admin-sidebar-logo-img">
      <div>
        <span class="logo-text">Eduka<span class="accent">Vision</span>News</span>
        <small>Panel Admin</small>
      </div>
      <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Tutup menu">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>

    <nav class="admin-nav">
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.dashboard')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
        Dashboard
      </a>

      <div class="admin-nav-label">Konten</div>
      <a href="<?php echo e(route('admin.articles.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.articles.*')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
        Berita
      </a>
      <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.categories.*')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h9"/></svg>
        Kategori
      </a>
      <a href="<?php echo e(route('admin.news-submissions.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.news-submissions.*')]); ?>" style="display:flex; align-items:center; justify-content:space-between;">
        <span style="display:flex; align-items:center; gap:10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M4 7l8 6 8-6"/></svg>
          Pengajuan Berita
        </span>
        <?php $__pendingSubs = \App\Models\NewsSubmission::status(\App\Models\NewsSubmission::STATUS_PENDING)->count(); ?>
        <?php if($__pendingSubs > 0): ?>
          <span class="badge badge-red" style="font-size:10.5px;"><?php echo e($__pendingSubs); ?></span>
        <?php endif; ?>
      </a>

      <a href="<?php echo e(route('admin.running-texts.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.running-texts.*')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h13"/></svg>
        Running Text
      </a>

      <div class="admin-nav-label">Analitik</div>
      <a href="<?php echo e(route('admin.stats.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.stats.*')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
        Laporan Statistik
      </a>

      <div class="admin-nav-label">Monetisasi</div>
      <a href="<?php echo e(route('admin.ads.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.ads.*')]); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 9h18"/></svg>
        Iklan / Ads
      </a>

      <div class="admin-nav-label">Pengaturan</div>
      <a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.users.*')]); ?>" style="display:flex; align-items:center; justify-content:space-between;">
        <span style="display:flex; align-items:center; gap:10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Akun Admin
        </span>
        <?php $__pendingAdmins = \App\Models\User::where('is_admin', true)->where('is_active', false)->count(); ?>
        <?php if($__pendingAdmins > 0): ?>
          <span class="badge badge-red" style="font-size:10.5px;"><?php echo e($__pendingAdmins); ?></span>
        <?php endif; ?>
      </a>
    </nav>

    <div class="admin-sidebar-foot">
      <a href="<?php echo e(route('admin.account.edit')); ?>" class="admin-user-chip" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('admin.account.*')]); ?>">
        <div class="admin-user-avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></div>
        <div>
          <div class="admin-user-name"><?php echo e(auth()->user()->name); ?></div>
          <div class="admin-user-role">Administrator</div>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto; flex-shrink:0; opacity:.5;"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
      </a>
      <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-ghost btn-sm btn-block">Keluar</button>
      </form>
    </div>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <div class="admin-topbar-left">
        <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="adminSidebar">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
          <h1><?php echo e($pageTitle ?? 'Dashboard'); ?></h1>
          <?php if(isset($pageSubtitle)): ?><p><?php echo e($pageSubtitle); ?></p><?php endif; ?>
        </div>
      </div>
      <a href="<?php echo e(route('home')); ?>" target="_blank" class="admin-view-site">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6M10 14L21 3"/></svg>
        <span>Lihat Situs</span>
      </a>
    </div>

    <div class="admin-content">
      <?php if(session('status')): ?>
        <div class="admin-flash success"><?php echo e(session('status')); ?></div>
      <?php endif; ?>
      <?php if($errors->any()): ?>
        <div class="admin-flash error"><?php echo e($errors->first()); ?></div>
      <?php endif; ?>

      <?php echo e($slot); ?>

    </div>
  </div>

</div>

</body>
</html><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/components/admin-layout.blade.php ENDPATH**/ ?>
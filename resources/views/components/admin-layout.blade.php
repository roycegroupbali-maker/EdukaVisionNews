<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle ?? 'Panel Admin' }} — EdukaVisionNews</title>
<meta name="robots" content="noindex, nofollow">
@vite(['resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body class="admin-body">

<div class="admin-shell">

  <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>

  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-brand">
      <img src="{{ asset('images/logo-icon.png') }}" alt="EdukaVisionNews" class="admin-sidebar-logo-img">
      <div>
        <span class="logo-text">Eduka<span class="accent">Vision</span>News</span>
        <small>Panel Admin</small>
      </div>
      <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Tutup menu">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>

    @php $__me = auth()->user(); @endphp
    <nav class="admin-nav">
      <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
        Dashboard
      </a>

      <div class="admin-nav-label">Konten</div>
      <a href="{{ route('admin.articles.index') }}" @class(['active' => request()->routeIs('admin.articles.*')]) style="display:flex; align-items:center; justify-content:space-between;">
        <span style="display:flex; align-items:center; gap:10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
          Berita
        </span>
        @if($__me->hasPermission('articles.publish'))
          @php $__pendingArticles = \App\Models\Article::status(\App\Models\Article::STATUS_PENDING)->count(); @endphp
          @if($__pendingArticles > 0)
            <span class="badge badge-blue" style="font-size:10.5px;">{{ $__pendingArticles }}</span>
          @endif
        @endif
      </a>
      @if($__me->hasPermission('categories.manage'))
        <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h9"/></svg>
          Kategori
        </a>
      @endif
      @if($__me->hasPermission('news_submissions.manage'))
        <a href="{{ route('admin.news-submissions.index') }}" @class(['active' => request()->routeIs('admin.news-submissions.*')]) style="display:flex; align-items:center; justify-content:space-between;">
          <span style="display:flex; align-items:center; gap:10px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M4 7l8 6 8-6"/></svg>
            Pengajuan Berita
          </span>
          @php $__pendingSubs = \App\Models\NewsSubmission::status(\App\Models\NewsSubmission::STATUS_PENDING)->count(); @endphp
          @if($__pendingSubs > 0)
            <span class="badge badge-red" style="font-size:10.5px;">{{ $__pendingSubs }}</span>
          @endif
        </a>
      @endif

      @if($__me->hasPermission('running_texts.manage'))
        <a href="{{ route('admin.running-texts.index') }}" @class(['active' => request()->routeIs('admin.running-texts.*')])>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h13"/></svg>
          Running Text
        </a>
      @endif

      @if($__me->hasPermission('stats.view'))
        <div class="admin-nav-label">Analitik</div>
        <a href="{{ route('admin.stats.index') }}" @class(['active' => request()->routeIs('admin.stats.*')])>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
          Laporan Statistik
        </a>
      @endif

      @if($__me->hasPermission('ads.manage'))
        <div class="admin-nav-label">Monetisasi</div>
        <a href="{{ route('admin.ads.index') }}" @class(['active' => request()->routeIs('admin.ads.*')])>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 9h18"/></svg>
          Iklan / Ads
        </a>
      @endif

      @if($__me->hasPermission('users.manage') || $__me->hasPermission('roles.manage'))
        <div class="admin-nav-label">Pengaturan</div>
        @if($__me->hasPermission('users.manage'))
          <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')]) style="display:flex; align-items:center; justify-content:space-between;">
            <span style="display:flex; align-items:center; gap:10px;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              Akun Admin
            </span>
            @php $__pendingAdmins = \App\Models\User::where('is_admin', true)->where('is_active', false)->count(); @endphp
            @if($__pendingAdmins > 0)
              <span class="badge badge-red" style="font-size:10.5px;">{{ $__pendingAdmins }}</span>
            @endif
          </a>
        @endif
        @if($__me->hasPermission('roles.manage'))
          <a href="{{ route('admin.roles.index') }}" @class(['active' => request()->routeIs('admin.roles.*')])>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
            Jabatan
          </a>
        @endif
      @endif
    </nav>

    <div class="admin-sidebar-foot">
      <a href="{{ route('admin.account.edit') }}" class="admin-user-chip" @class(['active' => request()->routeIs('admin.account.*')])>
        <div class="admin-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <div>
          <div class="admin-user-name">{{ auth()->user()->name }}</div>
          <div class="admin-user-role">{{ auth()->user()->role_name }}</div>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto; flex-shrink:0; opacity:.5;"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
      </a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
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
          <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
          @isset($pageSubtitle)<p>{{ $pageSubtitle }}</p>@endisset
        </div>
      </div>
      <a href="{{ route('home') }}" target="_blank" class="admin-view-site">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6M10 14L21 3"/></svg>
        <span>Lihat Situs</span>
      </a>
    </div>

    <div class="admin-content">
      @if(session('status'))
        <div class="admin-flash success">{{ session('status') }}</div>
      @endif
      @if($errors->any())
        <div class="admin-flash error">{{ $errors->first() }}</div>
      @endif

      {{ $slot }}
    </div>
  </div>

</div>

</body>
</html>
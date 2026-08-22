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

  <aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
      <img src="{{ asset('images/logo-icon.png') }}" alt="EdukaVisionNews" class="admin-sidebar-logo-img">
      <div>
        <span class="logo-text">Eduka<span class="accent">Vision</span>News</span>
        <small>Panel Admin</small>
      </div>
    </div>

    <nav class="admin-nav">
      <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
        Dashboard
      </a>

      <div class="admin-nav-label">Konten</div>
      <a href="{{ route('admin.articles.index') }}" @class(['active' => request()->routeIs('admin.articles.*')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
        Berita
      </a>
      <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h9"/></svg>
        Kategori
      </a>

      <div class="admin-nav-label">Monetisasi</div>
      <a href="{{ route('admin.ads.index') }}" @class(['active' => request()->routeIs('admin.ads.*')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 9h18"/></svg>
        Iklan / Ads
      </a>
    </nav>

    <div class="admin-sidebar-foot">
      <div class="admin-user-chip">
        <div class="admin-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <div>
          <div class="admin-user-name">{{ auth()->user()->name }}</div>
          <div class="admin-user-role">Administrator</div>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn btn-ghost btn-sm btn-block">Keluar</button>
      </form>
    </div>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <div>
        <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
        @isset($pageSubtitle)<p>{{ $pageSubtitle }}</p>@endisset
      </div>
      <a href="{{ route('home') }}" target="_blank" class="admin-view-site">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6M10 14L21 3"/></svg>
        Lihat Situs
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

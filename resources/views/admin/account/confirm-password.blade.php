<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Akses Terbatas — Panel Admin — EdukaVisionNews</title>
<meta name="robots" content="noindex, nofollow">
@vite(['resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body class="admin-body">

<div class="admin-auth">
  <div class="admin-auth-card">
    <div class="admin-auth-logo">
      <img src="{{ asset('images/logo-icon.png') }}" alt="EdukaVisionNews" class="admin-auth-logo-img">
      <span class="logo-text">Eduka<span class="accent">Vision</span>News</span>
    </div>

    <div class="lock-badge" aria-hidden="true">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
    </div>

    <h1>Akses Terbatas</h1>
    <p class="sub">Halaman Pengaturan Akun berisi data sensitif. Silakan masukkan kata sandi kamu untuk melanjutkan.</p>

    @if($errors->any())
      <div class="admin-flash error" style="margin-bottom:16px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.account.confirm-password.store') }}">
      @csrf
      <div class="field">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" required autofocus placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-accent btn-block">Konfirmasi &amp; Lanjutkan</button>
    </form>

    <p class="admin-auth-foot"><a href="{{ route('admin.dashboard') }}">&larr; Kembali ke Dashboard</a></p>
  </div>
</div>

</body>
</html>

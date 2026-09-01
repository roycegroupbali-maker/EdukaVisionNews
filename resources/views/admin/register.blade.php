<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Admin — EdukaVisionNews</title>
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

    <h1>Daftar Akun Admin</h1>
    <p class="sub">Khusus redaksi &amp; pengelola iklan EdukaVisionNews. Akun baru perlu dikonfirmasi/diaktifkan dulu oleh admin lain sebelum bisa dipakai untuk masuk.</p>

    @if($errors->any())
      <div class="admin-flash error" style="margin-bottom:16px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.register.attempt') }}">
      @csrf
      <div class="field">
        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap">
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@edukavisionnews.test">
      </div>
      <div class="field">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <div class="field">
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-accent btn-block">Daftar Akun</button>
    </form>

    <p class="admin-auth-foot">
      Sudah punya akun? <a href="{{ route('admin.login') }}">Masuk di sini</a>.
    </p>
    <p class="admin-auth-foot">© {{ now()->year }} EdukaVisionNews Media Group.</p>
  </div>
</div>

</body>
</html>

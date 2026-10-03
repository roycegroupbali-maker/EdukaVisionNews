<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atur Ulang Kata Sandi — EdukaVisionNews</title>
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

    <h1>Atur Ulang Kata Sandi</h1>
    <p class="sub">Buat kata sandi baru untuk akun Anda. Tautan ini hanya berlaku sekali dan dalam waktu terbatas.</p>

    @if(session('status'))
      <div class="admin-flash success" style="margin-bottom:16px;">{{ session('status') }}</div>
    @endif
    @if($errors->any())
      <div class="admin-flash error" style="margin-bottom:16px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email">
      </div>
      <div class="field">
        <label for="password">Kata Sandi Baru</label>
        <input type="password" id="password" name="password" required autofocus autocomplete="new-password" placeholder="••••••••">
      </div>
      <div class="field">
        <label for="password_confirmation">Ulangi Kata Sandi Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-accent btn-block">Simpan Kata Sandi Baru</button>
    </form>

    <p class="admin-auth-foot">
      <a href="{{ route('admin.login') }}">&larr; Kembali ke halaman masuk</a>
    </p>
    <p class="admin-auth-foot">© {{ now()->year }} EdukaVisionNews Media Group.</p>
  </div>
</div>

</body>
</html>

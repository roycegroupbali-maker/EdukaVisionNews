<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Kata Sandi — EdukaVisionNews</title>
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

    <h1>Lupa Kata Sandi</h1>
    <p class="sub">Masukkan email akun admin Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.</p>

    @if(session('status'))
      <div class="admin-flash success" style="margin-bottom:16px;">{{ session('status') }}</div>
    @endif
    @if($errors->any())
      <div class="admin-flash error" style="margin-bottom:16px;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}">
      @csrf
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="email@contoh.com">
      </div>
      <button type="submit" class="btn btn-accent btn-block">Kirim Tautan Reset</button>
    </form>

    <p class="admin-auth-foot">
      <a href="{{ route('admin.login') }}">&larr; Kembali ke halaman masuk</a>
    </p>
    <p class="admin-auth-foot">© {{ now()->year }} EdukaVisionNews Media Group.</p>
  </div>
</div>

</body>
</html>

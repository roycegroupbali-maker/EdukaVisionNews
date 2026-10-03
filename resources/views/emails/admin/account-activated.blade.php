@extends('emails.layout')

@section('title', 'Akun Admin Aktif — EdukaVisionNews')
@section('eyebrow', 'Akun Diaktifkan')
@section('preheader', 'Akun admin Anda sudah aktif dan siap dipakai untuk masuk.')
@section('footer_note')
Email ini dikirim otomatis oleh sistem EdukaVisionNews terkait akun panel admin Anda. Mohon tidak membalas langsung ke alamat email ini.
@endsection

@section('content')

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
    <tr><td><span style="display:inline-block; background-color:#E9F3EF; color:#1B4B43; border:1px solid #bcded1; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">&#10003; Akun Aktif</span></td></tr>
  </table>
  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:24px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">Halo, {{ $user->name }}.<br>Akun Anda sudah aktif.</h1>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;">Akun panel admin EdukaVisionNews dengan email <strong>{{ $user->email }}</strong> telah diaktifkan. Sekarang Anda dapat masuk memakai kata sandi yang Anda daftarkan.</p>
  <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr><td style="background-color:#0D1B3A; border-radius:3px;">
      <a href="{{ route('admin.login') }}" class="ev-btn" style="display:inline-block; font-family:'Helvetica Neue', Arial, sans-serif; font-size:13px; font-weight:600; color:#FFFFFF; padding:12px 26px; letter-spacing:0.02em;">Masuk ke Panel Admin &rarr;</a>
    </td></tr>
  </table>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; line-height:1.7; color:#6b675c; margin:0 0 16px;">Lupa kata sandi? Gunakan tautan "Lupa kata sandi?" di halaman masuk.</p>

@endsection

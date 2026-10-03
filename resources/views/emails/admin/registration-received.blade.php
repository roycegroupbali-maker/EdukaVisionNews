@extends('emails.layout')

@section('title', 'Pendaftaran Akun Admin Diterima — EdukaVisionNews')
@section('eyebrow', 'Konfirmasi Pendaftaran Akun')
@section('preheader', 'Pendaftaran akun admin Anda sudah kami terima dan menunggu aktivasi.')
@section('footer_note')
Email ini dikirim otomatis oleh sistem EdukaVisionNews terkait akun panel admin Anda. Mohon tidak membalas langsung ke alamat email ini.
@endsection

@section('content')

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
    <tr><td><span style="display:inline-block; background-color:#E9F3EF; color:#1B4B43; border:1px solid #bcded1; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">&#10003; Pendaftaran Diterima</span></td></tr>
  </table>
  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:24px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">Halo, {{ $user->name }}.<br>Pendaftaran akun Anda sudah kami terima.</h1>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;">Akun panel admin EdukaVisionNews dengan email <strong>{{ $user->email }}</strong> berhasil dibuat. Demi keamanan, akun baru perlu <strong>diaktifkan terlebih dahulu oleh admin</strong> sebelum bisa dipakai untuk masuk.</p>
  <h3 style="font-family:'Georgia','Times New Roman',serif; font-size:15px; color:#0D1B3A; margin:0 0 10px;">Apa selanjutnya?</h3>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;">1. Admin kami akan meninjau dan mengaktifkan akun Anda.<br>2. Anda akan menerima email pemberitahuan setelah akun aktif.<br>3. Setelah itu, Anda bisa masuk ke panel admin dengan email dan kata sandi yang Anda daftarkan.</p>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; line-height:1.7; color:#6b675c; margin:0 0 16px;">Kata sandi Anda tidak pernah kami kirim lewat email. Jika Anda tidak merasa mendaftar, abaikan email ini.</p>

@endsection

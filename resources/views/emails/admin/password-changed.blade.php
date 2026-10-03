@extends('emails.layout')

@section('title', 'Kata Sandi Diubah — EdukaVisionNews')
@section('eyebrow', 'Pemberitahuan Keamanan')
@section('preheader', 'Kata sandi akun admin Anda baru saja diubah.')
@section('footer_note')
Email ini dikirim otomatis oleh sistem EdukaVisionNews terkait akun panel admin Anda. Mohon tidak membalas langsung ke alamat email ini.
@endsection

@section('content')

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
    <tr><td><span style="display:inline-block; background-color:#E9F3EF; color:#1B4B43; border:1px solid #bcded1; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">&#10003; Kata Sandi Diubah</span></td></tr>
  </table>
  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:24px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">Halo, {{ $user->name }}.<br>Kata sandi Anda baru saja diubah.</h1>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;">Kata sandi akun panel admin <strong>{{ $user->email }}</strong> berhasil diubah pada {{ now()->translatedFormat('d M Y, H:i') }}. Semua sesi login lama pada akun ini sudah diakhiri.</p>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;"><strong>Bukan Anda yang melakukannya?</strong> Segera hubungi pengelola panel admin agar akun Anda dapat diamankan.</p>

@endsection

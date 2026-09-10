@extends('emails.layout')

@section('title', 'Usulan Berita Diterima — EdukaVisionNews')
@section('eyebrow', 'Konfirmasi Permohonan Berita')
@section('preheader', 'Usulan berita "'.$submission->title.'" sudah kami terima dan akan ditinjau oleh tim redaksi.')

@section('content')

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
    <tr>
      <td>
        <span style="display:inline-block; background-color:#E9F3EF; color:#1B4B43; border:1px solid #bcded1; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">
          &#10003; Berhasil Dikirim
        </span>
      </td>
    </tr>
  </table>

  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:24px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">
    Terima kasih, {{ $submission->name }}.<br>Usulan beritamu sudah kami terima.
  </h1>

  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 26px;">
    Tim redaksi EdukaVisionNews akan meninjau setiap laporan atau usulan berita yang masuk sebelum diputuskan untuk diangkat menjadi berita. Berikut ringkasan permohonan yang kamu kirimkan:
  </p>

  <!-- Submission detail card -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF8F3; border:1px solid #e4ddcd; margin-bottom:26px;">
    <tr>
      <td style="padding:22px 24px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="font-family:'Courier New', monospace; font-size:10.5px; letter-spacing:0.1em; text-transform:uppercase; color:#8f8a7c; padding-bottom:4px;">Judul Usulan Berita</td>
          </tr>
          <tr>
            <td style="font-family:'Georgia','Times New Roman',serif; font-size:17px; color:#0D1B3A; font-weight:700; padding-bottom:16px; line-height:1.4;">{{ $submission->title }}</td>
          </tr>
        </table>

        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e4ddcd; padding-top:14px;">
          <tr>
            <td width="33%" valign="top" style="padding-top:14px; font-family:'Helvetica Neue', Arial, sans-serif;">
              <div style="font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; margin-bottom:3px;">Nomor Tiket</div>
              <div style="font-size:13.5px; color:#22262B; font-weight:600;">#{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</div>
            </td>
            <td width="33%" valign="top" style="padding-top:14px; font-family:'Helvetica Neue', Arial, sans-serif;">
              <div style="font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; margin-bottom:3px;">Tanggal Kirim</div>
              <div style="font-size:13.5px; color:#22262B; font-weight:600;">{{ $submission->created_at->translatedFormat('d M Y, H:i') }}</div>
            </td>
            <td width="33%" valign="top" style="padding-top:14px; font-family:'Helvetica Neue', Arial, sans-serif;">
              <div style="font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; margin-bottom:3px;">Nomor Telepon</div>
              <div style="font-size:13.5px; color:#22262B; font-weight:600;">{{ $submission->phone ?: '—' }}</div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <h3 style="font-family:'Georgia','Times New Roman',serif; font-size:15px; color:#0D1B3A; margin:0 0 10px;">Apa selanjutnya?</h3>
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
    <tr>
      <td style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; line-height:1.8; color:#3d3a33;">
        1. Tim redaksi kami akan meninjau kelengkapan dan kelayakan informasi yang kamu kirimkan.<br>
        2. Jika diperlukan, kami akan menghubungimu lewat email ini atau nomor telepon yang kamu cantumkan.<br>
        3. Kamu akan menerima email pemberitahuan otomatis setiap kali status permohonanmu diperbarui oleh tim kami.
      </td>
    </tr>
  </table>

  <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
    <tr>
      <td style="background-color:#0D1B3A; border-radius:3px;">
        <a href="{{ url('/') }}" class="ev-btn" style="display:inline-block; font-family:'Helvetica Neue', Arial, sans-serif; font-size:13px; font-weight:600; color:#FFFFFF; padding:12px 26px; letter-spacing:0.02em;">Kunjungi EdukaVisionNews &rarr;</a>
      </td>
    </tr>
  </table>

@endsection

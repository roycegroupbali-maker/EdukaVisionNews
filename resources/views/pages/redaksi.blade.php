@include('partials.header', [
    'pageTitle' => 'Redaksi — EdukaVisionNews',
    'pageDescription' => 'Susunan redaksi dan kontak EdukaVisionNews.',
])

<div class="section-band">
  <div class="wrap">
    @include('partials.ad-slot', ['slot' => 'leaderboard'])
  </div>
</div>

<article class="section-band static-page">
  <div class="wrap" style="max-width:760px;">

    <nav style="font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.04em; margin-bottom:18px; color:var(--ink-soft, #667);">
      <a href="{{ route('home') }}">Beranda</a>
      &nbsp;/&nbsp;
      <span>Redaksi</span>
    </nav>

    <span class="tag">Redaksi</span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 12px;">Susunan Redaksi</h1>
    <p class="feature-dek" style="font-size:18px; margin-bottom:30px;">EdukaVisionNews dikelola oleh tim redaksi yang tunduk pada Kode Etik Jurnalistik dan Pedoman Pemberitaan Media Siber Dewan Pers.</p>

    <div class="redaksi-list" style="font-family:'IBM Plex Mono',monospace; font-size:14px;">
      @foreach($struktur as $blok)
        <div style="padding:16px 0; border-bottom:1px solid var(--line, #e5e5e5);">
          <div style="font-weight:700; letter-spacing:.03em; text-transform:uppercase; font-size:12px; opacity:.55; margin-bottom:6px;">{{ $blok['jabatan'] }}</div>
          <div style="font-family:'Fraunces', serif; font-size:17px; line-height:1.6;">{{ implode(', ', $blok['nama']) }}</div>
        </div>
      @endforeach
    </div>

    <div class="article-body" style="font-family:'Fraunces', serif; font-size:17px; line-height:1.8; margin-top:34px;">
      <h2 style="font-family:'Fraunces', serif; font-size:22px; margin-bottom:14px;">Kontak Redaksi</h2>
      <p style="margin-bottom:6px;"><strong>{{ $kontak['perusahaan'] }}</strong></p>
      <p style="margin-bottom:6px;">Alamat: {{ $kontak['alamat'] }}</p>
      <p style="margin-bottom:6px;">Email Redaksi: <a href="mailto:{{ $kontak['email_redaksi'] }}">{{ $kontak['email_redaksi'] }}</a></p>
      <p style="margin-bottom:6px;">Email Kerja Sama: <a href="mailto:{{ $kontak['email_kerja_sama'] }}">{{ $kontak['email_kerja_sama'] }}</a></p>
      <p style="margin-bottom:20px;">Telepon: {{ $kontak['telepon'] }}</p>

      <p style="font-size:14px; opacity:.65;">Isi pemberitaan EdukaVisionNews tunduk pada <a href="{{ route('pages.pedoman') }}">Pedoman Media Siber</a> yang ditetapkan Dewan Pers.</p>
    </div>

  </div>
</article>

@include('partials.footer')

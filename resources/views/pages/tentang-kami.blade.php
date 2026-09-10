@include('partials.header', [
    'pageTitle' => 'Tentang Kami — EdukaVisionNews',
    'pageDescription' => 'Profil EdukaVisionNews, portal berita harian yang merangkum kabar nasional, dunia, bisnis, olahraga, gaya hidup, edukasi, dan resep Nusantara.',
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
      <span>Tentang Kami</span>
    </nav>

    <span class="tag">Tentang Kami</span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 8px;">Tentang EdukaVisionNews</h1>
    <p style="font-family:'Fraunces', serif; font-style:italic; font-size:16px; opacity:.7; margin:0 0 20px;">"Cerdas Informasinya, Terang Visinya."</p>

     <div class="article-body" style="font-family:'Fraunces', serif; font-size:18px; line-height:1.8; color:var(--ink,#1a1a1a); text-align: justify;">
      <p style="margin-bottom:20px;">EdukaVisionNews adalah portal berita harian berbasis di Bali yang hadir untuk merangkum denyut kabar nasional, dunia, bisnis, olahraga, gaya hidup, dunia pendidikan, hingga resep Nusantara dalam satu tempat. Kami percaya informasi yang akurat dan mudah diakses adalah kebutuhan dasar masyarakat modern, sehingga setiap hari tim redaksi kami menyaring, memverifikasi, dan menyajikan berita dengan bahasa yang jernih.</p>

      <p style="margin-bottom:20px;">Nama "EdukaVision" merefleksikan dua nilai yang kami pegang: <em>edukasi</em> sebagai semangat untuk mencerdaskan pembaca, dan <em>visi</em> sebagai komitmen menghadirkan sudut pandang yang luas dan berimbang atas setiap peristiwa.</p>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px; text-align:left;">Visi</h2>
      <p style="margin-bottom:20px;">Menjadi media berita dan informasi yang terpercaya, edukatif, independen, dan inspiratif dalam mencerdaskan masyarakat serta mendorong kemajuan bangsa.</p>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px; text-align:left;">Misi</h2>
      <ul style="margin-bottom:20px; padding-left:22px;">
        <li style="margin-bottom:8px;">Menyajikan informasi yang akurat dan terpercaya berdasarkan fakta, data, dan prinsip jurnalistik yang bertanggung jawab.</li>
        <li style="margin-bottom:8px;">Menghadirkan konten edukatif yang memperluas wawasan dan meningkatkan literasi masyarakat.</li>
        <li style="margin-bottom:8px;">Menjaga independensi dan integritas jurnalistik dengan mengedepankan objektivitas, keberimbangan, dan kepentingan publik.</li>
        <li style="margin-bottom:8px;">Membuka ruang bagi berbagai perspektif dan menjadi jembatan komunikasi antara masyarakat, pemerintah, komunitas, serta pemangku kepentingan lainnya.</li>
        <li style="margin-bottom:8px;">Mengangkat isu dan potensi daerah, serta kisah-kisah inspiratif yang memberi dampak positif bagi masyarakat.</li>
        <li style="margin-bottom:8px;">Memanfaatkan teknologi dan media digital untuk menyampaikan informasi secara cepat, menarik, dan mudah diakses.</li>
        <li style="margin-bottom:8px;">Mendorong masyarakat untuk lebih kritis, cerdas, dan bijak dalam menerima maupun menyebarkan informasi.</li>
      </ul>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px; text-align:left;">Legalitas & Kontak</h2>
      <p style="margin-bottom:6px; text-align:left;"><strong>Penerbit:</strong> PT Eduka Vision Media Nusantara</p>
      <p style="margin-bottom:6px; text-align:left;"><strong>Alamat:</strong> Jl. Kertapura IIIB No. 23B, Denpasar</p>
      <p style="margin-bottom:6px; text-align:left;"><strong>Email Redaksi:</strong> redaksi@edukavisionnews.id</p>
      <p style="margin-bottom:20px; text-align:left;"><strong>Telepon:</strong> 089601469218</p>

      <p style="font-size:14px; opacity:.65; text-align:left;">Susunan redaksi lengkap dapat dilihat di halaman <a href="{{ route('pages.redaksi') }}">Redaksi</a>, dan panduan pemberitaan kami mengacu pada <a href="{{ route('pages.pedoman') }}">Pedoman Media Siber</a> Dewan Pers.</p>
    </div>

  </div>
</article>

@include('partials.footer')

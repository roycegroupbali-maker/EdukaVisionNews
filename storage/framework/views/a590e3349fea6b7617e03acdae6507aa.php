<?php echo $__env->make('partials.header', [
    'pageTitle' => 'Tentang Kami — EdukaVisionNews',
    'pageDescription' => 'Profil EdukaVisionNews, portal berita harian yang merangkum kabar nasional, dunia, bisnis, olahraga, gaya hidup, edukasi, dan resep Nusantara.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="section-band">
  <div class="wrap">
    <?php echo $__env->make('partials.ad-slot', ['slot' => 'leaderboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</div>

<article class="section-band static-page">
  <div class="wrap" style="max-width:760px;">

    <nav style="font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.04em; margin-bottom:18px; color:var(--ink-soft, #667);">
      <a href="<?php echo e(route('home')); ?>">Beranda</a>
      &nbsp;/&nbsp;
      <span>Tentang Kami</span>
    </nav>

    <span class="tag">Tentang Kami</span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 20px;">Tentang EdukaVisionNews</h1>

    <div class="article-body" style="font-family:'Fraunces', serif; font-size:18px; line-height:1.8; color:var(--ink,#1a1a1a);">
      <p style="margin-bottom:20px;">EdukaVisionNews adalah portal berita harian berbasis di Bali yang hadir untuk merangkum denyut kabar nasional, dunia, bisnis, olahraga, gaya hidup, dunia pendidikan, hingga resep Nusantara dalam satu tempat. Kami percaya informasi yang akurat dan mudah diakses adalah kebutuhan dasar masyarakat modern, sehingga setiap hari tim redaksi kami menyaring, memverifikasi, dan menyajikan berita dengan bahasa yang jernih.</p>

      <p style="margin-bottom:20px;">Nama "EdukaVision" merefleksikan dua nilai yang kami pegang: <em>edukasi</em> sebagai semangat untuk mencerdaskan pembaca, dan <em>visi</em> sebagai komitmen menghadirkan sudut pandang yang luas dan berimbang atas setiap peristiwa.</p>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px;">Visi</h2>
      <p style="margin-bottom:20px;">Menjadi rujukan berita digital yang terpercaya, mencerdaskan, dan relevan bagi masyarakat Indonesia di tengah arus informasi yang terus berkembang.</p>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px;">Misi</h2>
      <ul style="margin-bottom:20px; padding-left:22px;">
        <li style="margin-bottom:8px;">Menyajikan berita yang akurat, berimbang, dan telah melalui proses verifikasi redaksi.</li>
        <li style="margin-bottom:8px;">Mendorong literasi media dan berpikir kritis melalui konten edukatif.</li>
        <li style="margin-bottom:8px;">Menjunjung tinggi Kode Etik Jurnalistik dan Pedoman Pemberitaan Media Siber.</li>
        <li style="margin-bottom:8px;">Menjaga independensi ruang redaksi dari kepentingan komersial maupun politik.</li>
      </ul>

      <h2 style="font-family:'Fraunces', serif; font-size:24px; margin:30px 0 12px;">Legalitas & Kontak</h2>
      <p style="margin-bottom:6px;"><strong>Penerbit:</strong> PT Eduka Vision Media Nusantara</p>
      <p style="margin-bottom:6px;"><strong>Alamat:</strong> Jl. Raya Legian No. 88, Kuta, Badung, Bali 80361, Indonesia</p>
      <p style="margin-bottom:6px;"><strong>Email Redaksi:</strong> redaksi@edukavisionnews.id</p>
      <p style="margin-bottom:20px;"><strong>Telepon:</strong> (0361) 700-1234</p>

      <p style="font-size:14px; opacity:.65;">Susunan redaksi lengkap dapat dilihat di halaman <a href="<?php echo e(route('pages.redaksi')); ?>">Redaksi</a>, dan panduan pemberitaan kami mengacu pada <a href="<?php echo e(route('pages.pedoman')); ?>">Pedoman Media Siber</a> Dewan Pers.</p>
    </div>

  </div>
</article>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/pages/tentang-kami.blade.php ENDPATH**/ ?>
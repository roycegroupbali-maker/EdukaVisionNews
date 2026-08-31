<!-- ============ NEWSLETTER ============ -->
<section class="newsletter">
  <div class="wrap">
    <div>
      <h3 class="display">Ikuti denyut kabar setiap pagi</h3>
      <p>Ringkasan berita nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep pilihan langsung ke kotak masuk kamu, setiap hari pukul 6 pagi.</p>
    </div>
    <form class="newsletter-form" id="newsletterForm">
      <input type="email" id="newsletterEmail" placeholder="Alamat email kamu" aria-label="Alamat email" required>
      <button type="submit">Berlangganan</button>
    </form>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer>
  <div class="wrap">
    <div class="footer-grid">
      <div>
        <div class="footer-logo">
          <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="EdukaVisionNews" class="footer-logo-img">
          <span class="logo-text">EdukaVisionNews</span>
        </div>
        <p class="footer-tagline">Portal berita harian yang merangkum kabar nasional, dunia, bisnis, olahraga, gaya hidup, dunia pendidikan, dan dapur Nusantara dalam satu denyut yang sama.</p>
      </div>
      <div class="footer-col">
        <h4>Kategori</h4>
        <ul>
          <?php $__currentLoopData = ($categories ?? [])->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(route('category.show', $c->slug)); ?>"><?php echo e($c->name); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Lainnya</h4>
        <ul>
          <?php $__currentLoopData = ($categories ?? [])->slice(4, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(route('category.show', $c->slug)); ?>"><?php echo e($c->name); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Tentang Kami</h4>
        <ul>
          <li><a href="<?php echo e(route('pages.about')); ?>">Tentang Kami</a></li>
          <li><a href="<?php echo e(route('pages.redaksi')); ?>">Redaksi</a></li>
          <li><a href="#">Karier</a></li>
          <li><a href="<?php echo e(route('pages.pedoman')); ?>">Pedoman Media Siber</a></li>
          <li><a href="<?php echo e(route('pages.redaksi')); ?>">Kontak</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Ikuti Kami</h4>
        <div class="socials">
          <a href="#" aria-label="Instagram"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg></a>
          <a href="#" aria-label="X"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4l16 16M20 4L4 20"/></svg></a>
          <a href="#" aria-label="YouTube"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="6" width="18" height="12" rx="3"/><path d="M11 10l4 2-4 2v-4z" fill="currentColor" stroke="none"/></svg></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <?php echo e(now()->year); ?> EdukaVisionNews Media Group. Seluruh hak cipta dilindungi.</span>
      <span>Powered By SKYNUSA TECH</span>
      <span>
        <?php if(auth()->guard()->check()): ?>
          <a href="<?php echo e(route('admin.dashboard')); ?>" style="opacity:.45; font-size:11px;">Admin</a>
        <?php else: ?>
          <a href="<?php echo e(route('admin.login')); ?>" style="opacity:.45; font-size:11px;">Admin</a>
        <?php endif; ?>
      </span>
    </div>
    <p class="ad-disclosure">Konten yang ditandai "Konten Bersponsor" atau "Iklan" dibiayai oleh mitra pengiklan dan diberi label sesuai Pedoman Media Siber Dewan Pers. Redaksi menjaga independensi peliputan berita dari materi berbayar.</p>
  </div>
</footer>

<!-- ============ BACK TO TOP ============ -->
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<!-- ============ MOBILE STICKY AD ============ -->
<?php $__mobileAd = ($ads['mobile_bar'] ?? null); ?>
<div class="mobile-ad-bar" id="mobileAdBar">
  <div>
    <span class="ad-eyebrow">Iklan</span>
    <div class="mobile-ad-bar-text"><?php echo e($__mobileAd?->title ?? 'Info Produk Sponsor · Ketuk untuk lihat'); ?></div>
  </div>
  <div style="display:flex; align-items:center; gap:10px;">
    <?php if($__mobileAd): ?>
      <a href="<?php echo e(route('ads.click', $__mobileAd)); ?>" target="_blank" rel="noopener sponsored" class="mobile-ad-cta"><?php echo e($__mobileAd->cta_text ?: 'Lihat'); ?></a>
    <?php else: ?>
      <button class="mobile-ad-cta">Lihat</button>
    <?php endif; ?>
    <button class="mobile-ad-close" id="mobileAdClose" aria-label="Tutup iklan">✕</button>
  </div>
</div>

</body>
</html>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/footer.blade.php ENDPATH**/ ?>
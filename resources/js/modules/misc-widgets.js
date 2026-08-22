/* Kumpulan interaksi kecil: muat lebih banyak berita, tombol kembali ke atas,
   form newsletter, tombol bookmark, dan penutup iklan sticky mobile. */

export function initLoadMore() {
  const loadMoreBtn = document.getElementById('loadMoreBerita');
  if (!loadMoreBtn) return;

  loadMoreBtn.addEventListener('click', () => {
    document.querySelectorAll('.berita-extra').forEach((el) => {
      el.style.display = 'flex';
    });
    loadMoreBtn.textContent = 'Semua Berita Telah Dimuat';
    loadMoreBtn.disabled = true;
  });
}

export function initBackToTop() {
  const backTop = document.getElementById('backToTop');
  if (!backTop) return;

  window.addEventListener(
    'scroll',
    () => {
      backTop.classList.toggle('visible', window.scrollY > 700);
    },
    { passive: true }
  );
  backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

export function initNewsletterForm() {
  const nlForm = document.getElementById('newsletterForm');
  if (!nlForm) return;

  nlForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const emailInput = document.getElementById('newsletterEmail');
    const email = emailInput ? emailInput.value.trim() : '';
    nlForm.outerHTML =
      '<div class="nl-success">✓ Terima kasih sudah mendaftar dengan ' +
      (email || 'alamat kamu') +
      '. Ringkasan berita akan mulai dikirim ke email tersebut.</div>';
  });
}

export function initBookmarkButton() {
  const bookmarkBtn = document.getElementById('bookmarkBtn');
  if (!bookmarkBtn) return;

  bookmarkBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    bookmarkBtn.classList.toggle('saved');
  });
}

export function initMobileAdDismiss() {
  const adClose = document.getElementById('mobileAdClose');
  const mobileAd = document.getElementById('mobileAdBar');
  if (!adClose || !mobileAd) return;

  adClose.addEventListener('click', () => {
    mobileAd.style.display = 'none';
  });
}

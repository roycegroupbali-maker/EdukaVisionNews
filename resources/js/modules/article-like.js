/* Tombol "Suka" di halaman detail berita (fitur tentative — server yang
   memutuskan aktif/tidaknya lewat config('features.likes_enabled'); kalau
   dimatikan, tombol ini bahkan tidak dirender oleh Blade, jadi modul ini
   otomatis tidak melakukan apa-apa). */
export function initArticleLike() {
  const btn = document.getElementById('likeBtn');
  if (!btn) return;

  const likeUrl = btn.getAttribute('data-like-url');
  const slug = btn.getAttribute('data-article-slug') || '';
  const countEl = document.getElementById('likeCount');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  // Status "sudah like" versi tampilan disimpan di localStorage per-browser
  // murni supaya tombol langsung terlihat terisi saat halaman dibuka lagi.
  // Sumber kebenaran anti-spam yang sesungguhnya tetap di server (cookie
  // pengunjung + constraint UNIQUE di database), bukan di sini.
  const storageKey = `evn_liked_${slug}`;
  if (localStorage.getItem(storageKey) === '1') {
    btn.classList.add('is-liked');
    btn.setAttribute('aria-pressed', 'true');
  }

  if (!likeUrl) return;

  btn.addEventListener('click', async () => {
    if (btn.disabled) return;
    btn.disabled = true;

    try {
      const res = await fetch(likeUrl, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          Accept: 'application/json',
        },
      });
      const data = await res.json();

      if (data && typeof data.likes === 'number' && countEl) {
        countEl.textContent = data.likes.toLocaleString('id-ID');
      }

      if (data && data.liked) {
        btn.classList.add('is-liked');
        btn.setAttribute('aria-pressed', 'true');
        localStorage.setItem(storageKey, '1');
      } else {
        btn.classList.remove('is-liked');
        btn.setAttribute('aria-pressed', 'false');
        localStorage.removeItem(storageKey);
      }
    } catch (err) {
      // Diamkan — kalau gagal, tombol tetap bisa dicoba lagi oleh pengunjung.
    } finally {
      btn.disabled = false;
    }
  });
}

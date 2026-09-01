/* Tombol "Salin Tautan" di halaman detail berita — menyalin URL ke clipboard
   sekaligus melapor ke server supaya jumlah share ikut tercatat. */
export function initArticleShare() {
  const shareRow = document.querySelector('.share-row');
  if (!shareRow) return;

  const copyBtn = shareRow.querySelector('[data-copy-btn]');
  if (!copyBtn) return;

  const copyUrl = shareRow.getAttribute('data-copy-url');
  const articleUrl = shareRow.getAttribute('data-article-url');
  const label = copyBtn.querySelector('.share-copy-label');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  const shareCountEl = document.getElementById('shareCount');

  copyBtn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(articleUrl);
    } catch (err) {
      // Clipboard API mungkin tidak tersedia (browser lama/http tanpa TLS);
      // tautan tetap tersalin secara visual lewat fallback di bawah.
      const tmp = document.createElement('textarea');
      tmp.value = articleUrl;
      tmp.style.position = 'fixed';
      tmp.style.opacity = '0';
      document.body.appendChild(tmp);
      tmp.select();
      document.execCommand('copy');
      document.body.removeChild(tmp);
    }

    if (label) {
      const original = label.textContent;
      label.textContent = 'Tersalin!';
      copyBtn.classList.add('copied');
      setTimeout(() => {
        label.textContent = original;
        copyBtn.classList.remove('copied');
      }, 2000);
    }

    if (!copyUrl) return;

    try {
      const res = await fetch(copyUrl, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          Accept: 'application/json',
        },
      });
      const data = await res.json();
      if (data && typeof data.shares === 'number' && shareCountEl) {
        shareCountEl.textContent = data.shares.toLocaleString('id-ID') + ' DIBAGIKAN';
      }
    } catch (err) {
      // Diamkan saja kalau gagal — menyalin tautan tetap berhasil untuk pengguna.
    }
  });
}

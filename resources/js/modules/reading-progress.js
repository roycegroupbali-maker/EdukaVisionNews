/* Mengisi bar tipis di atas halaman sesuai progres scroll membaca artikel */
export function initReadingProgress() {
  const progressBar = document.getElementById('readProgress');
  if (!progressBar) return;

  function updateProgress() {
    const h = document.documentElement;
    const scrollable = h.scrollHeight - h.clientHeight;
    const pct = scrollable > 0 ? (h.scrollTop / scrollable) * 100 : 0;
    progressBar.style.width = pct + '%';
  }

  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();
}

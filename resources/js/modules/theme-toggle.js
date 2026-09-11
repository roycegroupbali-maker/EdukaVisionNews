/* Tombol ganti mode terang / gelap.
   Preferensi disimpan di localStorage supaya tetap konsisten saat pengguna
   pindah halaman (setiap halaman di sini reload penuh, bukan SPA). */
export function initThemeToggle() {
  const themeBtn = document.getElementById('themeToggle');
  if (!themeBtn) return;

  const STORAGE_KEY = 'evn_theme';
  let isDark = localStorage.getItem(STORAGE_KEY) === 'dark';
  document.body.setAttribute('data-theme', isDark ? 'dark' : 'light');

  themeBtn.addEventListener('click', () => {
    isDark = !isDark;
    document.body.setAttribute('data-theme', isDark ? 'dark' : 'light');
    localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
  });
}
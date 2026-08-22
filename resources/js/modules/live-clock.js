/* Menampilkan jam berjalan (WITA) di top bar */
export function initLiveClock() {
  const el = document.getElementById('liveClock');
  if (!el) return;

  function pad(n) {
    return n.toString().padStart(2, '0');
  }

  function tick() {
    const now = new Date();
    el.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
  }

  tick();
  setInterval(tick, 1000);
}

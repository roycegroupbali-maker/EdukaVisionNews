/* Menampilkan jam berjalan di top bar, mengikuti zona waktu perangkat pembaca
   (bukan dipaksa WITA) — labelnya (WIB/WITA/WIT/GMT+X) ikut menyesuaikan.

   Indonesia tidak memakai daylight saving time, jadi offset UTC tiap zona
   selalu tetap: WIB = UTC+7, WITA = UTC+8, WIT = UTC+9. Kita baca offset
   browser pembaca lalu cocokkan ke salah satu dari tiga itu; kalau
   pembacanya dari luar ketiga zona itu (mis. luar negeri), tampilkan jam
   lokal mereka dengan label GMT yang sesuai, bukan dipaksa WIB/WITA/WIT. */
export function initLiveClock() {
  const el = document.getElementById('liveClock');
  const zoneEl = document.getElementById('liveClockZone');
  if (!el) return;

  function zoneLabel() {
    // getTimezoneOffset() mengembalikan menit dalam arah terbalik
    // (mis. WITA/UTC+8 -> -480), jadi dibalik dulu biar intuitif.
    const offsetMinutes = -new Date().getTimezoneOffset();

    if (offsetMinutes === 7 * 60) return 'WIB';
    if (offsetMinutes === 8 * 60) return 'WITA';
    if (offsetMinutes === 9 * 60) return 'WIT';

    const sign = offsetMinutes >= 0 ? '+' : '-';
    const abs = Math.abs(offsetMinutes);
    const hours = Math.floor(abs / 60);
    const minutes = abs % 60;
    return `GMT${sign}${hours}${minutes ? ':' + String(minutes).padStart(2, '0') : ''}`;
  }

  const formatter = new Intl.DateTimeFormat('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false,
  });

  function tick() {
    el.textContent = formatter.format(new Date());
  }

  tick();
  if (zoneEl) zoneEl.textContent = zoneLabel();
  setInterval(tick, 1000);
}
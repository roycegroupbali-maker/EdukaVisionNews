/* ==========================================================================
   Accessibility Tools — tombol melayang untuk bantuan disabilitas
   Semua preferensi disimpan di localStorage supaya tetap aktif saat
   pengguna pindah halaman atau kembali lagi nanti.
   ========================================================================== */

const STORAGE_KEY = 'evn_a11y_prefs';
const FONT_SCALE_MIN = 0.8;
const FONT_SCALE_MAX = 1.6;
const FONT_SCALE_STEP = 0.1;

const defaults = {
  adhd: false,
  lowcolor: false,
  contrast: false,
  readingmask: false,
  dyslexia: false,
  align: null,          // 'left' | 'center' | 'right' | 'justify'
  lineheight: null,      // 'tight' | 'wide'
  letterspacing: 'normal',
  fontScale: 1,
};

function loadPrefs() {
  try {
    const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
    return { ...defaults, ...saved };
  } catch (e) {
    return { ...defaults };
  }
}

function savePrefs(prefs) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(prefs));
}

export function initAccessibilityWidget() {
  const toggleBtn = document.getElementById('a11yToggle');
  const panel = document.getElementById('a11yPanel');
  const overlay = document.getElementById('a11yOverlay');
  const closeBtn = document.getElementById('a11yClose');
  const resetBtn = document.getElementById('a11yReset');
  const mask = document.getElementById('a11yReadingMask');

  if (!toggleBtn || !panel) return;

  // Pindahkan elemen widget keluar dari <body> jadi anak langsung <html>,
  // supaya tidak ikut kena efek containing-block dari CSS `filter`
  // (Low Color / Contrast) yang diterapkan ke <body>.
  [toggleBtn, overlay, panel, mask].forEach((el) => {
    if (el) document.documentElement.appendChild(el);
  });

  let prefs = loadPrefs();

  const body = document.body;

  const alignClasses = ['a11y-align-left', 'a11y-align-center', 'a11y-align-right', 'a11y-align-justify'];
  const lineheightClasses = ['a11y-lineheight-tight', 'a11y-lineheight-wide'];
  const letterspacingClasses = ['a11y-letterspacing-normal', 'a11y-letterspacing-medium', 'a11y-letterspacing-wide'];

  function applyAll() {
    body.classList.toggle('a11y-adhd', !!prefs.adhd);
    body.classList.toggle('a11y-lowcolor', !!prefs.lowcolor);
    body.classList.toggle('a11y-contrast', !!prefs.contrast);
    body.classList.toggle('a11y-readingmask', !!prefs.readingmask);
    mask?.classList.toggle('show', !!prefs.readingmask);
    body.classList.toggle('a11y-dyslexia', !!prefs.dyslexia);

    alignClasses.forEach((c) => body.classList.remove(c));
    if (prefs.align) body.classList.add(`a11y-align-${prefs.align}`);

    lineheightClasses.forEach((c) => body.classList.remove(c));
    if (prefs.lineheight) body.classList.add(`a11y-lineheight-${prefs.lineheight}`);

    letterspacingClasses.forEach((c) => body.classList.remove(c));
    body.classList.add(`a11y-letterspacing-${prefs.letterspacing}`);

    body.style.setProperty('--a11y-font-scale', prefs.fontScale);

    // Sinkronkan state tombol aktif di panel
    panel.querySelectorAll('[data-toggle]').forEach((btn) => {
      const key = btn.dataset.toggle;
      btn.classList.toggle('active', !!prefs[key]);
    });
    panel.querySelectorAll('[data-select]').forEach((btn) => {
      const key = btn.dataset.select;
      btn.classList.toggle('active', prefs[key] === btn.dataset.value);
    });

    toggleBtn.classList.toggle(
      'active',
      prefs.adhd || prefs.lowcolor || prefs.contrast || prefs.readingmask || prefs.dyslexia ||
      !!prefs.align || !!prefs.lineheight || prefs.letterspacing !== 'normal' || prefs.fontScale !== 1
    );
  }

  function updatePrefs(patch) {
    prefs = { ...prefs, ...patch };
    savePrefs(prefs);
    applyAll();
  }

  function openPanel() {
    panel.classList.add('open');
    overlay.classList.add('open');
    toggleBtn.setAttribute('aria-expanded', 'true');
  }
  function closePanel() {
    panel.classList.remove('open');
    overlay.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
  }

  toggleBtn.addEventListener('click', () => {
    panel.classList.contains('open') ? closePanel() : openPanel();
  });
  closeBtn?.addEventListener('click', closePanel);
  overlay?.addEventListener('click', closePanel);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && panel.classList.contains('open')) closePanel();
  });

  // Tombol toggle sederhana (on/off)
  panel.querySelectorAll('[data-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const key = btn.dataset.toggle;
      updatePrefs({ [key]: !prefs[key] });
    });
  });

  // Tombol pilihan (satu aktif dalam grup, klik ulang untuk mematikan)
  panel.querySelectorAll('[data-select]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const key = btn.dataset.select;
      const value = btn.dataset.value;
      updatePrefs({ [key]: prefs[key] === value ? (key === 'letterspacing' ? 'normal' : null) : value });
    });
  });

  // Tombol ukuran huruf
  panel.querySelectorAll('[data-action]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const action = btn.dataset.action;
      let scale = prefs.fontScale;
      if (action === 'font-bigger') scale = Math.min(FONT_SCALE_MAX, +(scale + FONT_SCALE_STEP).toFixed(2));
      if (action === 'font-smaller') scale = Math.max(FONT_SCALE_MIN, +(scale - FONT_SCALE_STEP).toFixed(2));
      updatePrefs({ fontScale: scale });
    });
  });

  // Reset semua
  resetBtn?.addEventListener('click', () => {
    prefs = { ...defaults };
    savePrefs(prefs);
    applyAll();
  });

  // Reading mask mengikuti kursor / sentuhan
  if (mask) {
    mask.style.top = `${window.innerHeight / 2 - 40}px`;
    const moveMask = (y) => {
      mask.style.top = `${y - 40}px`;
    };
    window.addEventListener('mousemove', (e) => moveMask(e.clientY));
    window.addEventListener('touchmove', (e) => {
      if (e.touches[0]) moveMask(e.touches[0].clientY);
    }, { passive: true });
  }

  applyAll();
}
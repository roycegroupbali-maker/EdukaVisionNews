// EdukaVisionNews — Admin panel JS (ringan, tanpa framework)

document.addEventListener('DOMContentLoaded', () => {
  // Sidebar mobile (off-canvas drawer): buka/tutup lewat tombol hamburger,
  // tombol X di dalam sidebar, klik backdrop, tombol Escape, atau saat
  // memilih salah satu menu navigasi.
  const sidebar = document.getElementById('adminSidebar');
  const backdrop = document.getElementById('adminSidebarBackdrop');
  const menuToggle = document.getElementById('adminMenuToggle');
  const sidebarClose = document.getElementById('adminSidebarClose');

  function openSidebar() {
    if (!sidebar || !backdrop) return;
    sidebar.classList.add('is-open');
    backdrop.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
  }

  function closeSidebar() {
    if (!sidebar || !backdrop) return;
    sidebar.classList.remove('is-open');
    backdrop.classList.remove('is-open');
    document.body.style.overflow = '';
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
  }

  if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => {
      sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });
  }
  if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeSidebar();
  });
  // Tutup drawer begitu memilih menu, biar tidak nutupin halaman berikutnya
  if (sidebar) {
    sidebar.querySelectorAll('a, button[type="submit"]').forEach((el) => {
      el.addEventListener('click', closeSidebar);
    });
  }
  // Kalau layar dibesarkan lagi ke ukuran desktop, pastikan state drawer direset
  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) closeSidebar();
  });

  // Konfirmasi sebelum menghapus data (berita, kategori, iklan)
  document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      const msg = form.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
      if (!window.confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // Preview gambar sebelum diupload (dipakai form iklan & form artikel)
  function bindImagePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if (!input || !preview) return;
    input.addEventListener('change', () => {
      const file = input.files && input.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  }
  bindImagePreview('adImageInput', 'adImagePreview');
  bindImagePreview('articleImageInput', 'articleImagePreview');

  // Kalau admin memilih gambar baru untuk artikel, otomatis lepas centang
  // "hapus gambar" supaya tidak ada dua instruksi yang bertabrakan.
  const articleImageInput = document.getElementById('articleImageInput');
  const removeImageCheckbox = document.getElementById('removeImage');
  if (articleImageInput && removeImageCheckbox) {
    articleImageInput.addEventListener('change', () => {
      if (articleImageInput.files && articleImageInput.files[0]) {
        removeImageCheckbox.checked = false;
      }
    });
  }

  // Live preview art SVG di form artikel saat warna/pola diganti
  const c1 = document.getElementById('artColor1');
  const c2 = document.getElementById('artColor2');
  const patternInputs = document.querySelectorAll('input[name="art_pattern"]');
  const preview = document.getElementById('artPreviewSvg');

  function renderArtPreview() {
    if (!preview) return;
    const color1 = c1 ? c1.value : '#0D1B3A';
    const color2 = c2 ? c2.value : '#2a3f75';
    const pattern = document.querySelector('input[name="art_pattern"]:checked');
    const p = pattern ? pattern.value : 'wave';
    const vw = 300, vh = 225;

    let shape = '';
    if (p === 'circles') {
      shape = `<circle cx="${vw * 0.7}" cy="${vh * 0.35}" r="${vh * 0.3}" fill="${color2}" opacity="0.5"/>
        <circle cx="${vw * 0.7}" cy="${vh * 0.35}" r="${vh * 0.15}" fill="${color2}" opacity="0.4"/>`;
    } else if (p === 'triangle') {
      shape = `<path d="M${vw * 0.2} ${vh * 0.8} L${vw * 0.5} ${vh * 0.25} L${vw * 0.8} ${vh * 0.8} Z" fill="${color2}" opacity="0.35"/>`;
    } else if (p === 'grid') {
      shape = `<rect x="${vw * 0.23}" y="${vh * 0.3}" width="${vw * 0.54}" height="${vh * 0.42}" rx="6" fill="none" stroke="${color2}" stroke-width="1.5" opacity="0.4"/>`;
    } else if (p === 'dots') {
      shape = `<circle cx="${vw * 0.35}" cy="${vh * 0.5}" r="4" fill="${color2}" opacity="0.6"/>
        <circle cx="${vw * 0.5}" cy="${vh * 0.4}" r="4" fill="${color2}" opacity="0.6"/>
        <circle cx="${vw * 0.65}" cy="${vh * 0.55}" r="4" fill="${color2}" opacity="0.6"/>`;
    } else if (p === 'arrow') {
      shape = `<path d="M${vw * 0.13} ${vh * 0.8} L${vw * 0.33} ${vh * 0.53} L${vw * 0.5} ${vh * 0.66} L${vw * 0.8} ${vh * 0.35}" stroke="${color2}" stroke-width="2" fill="none" opacity="0.6"/>`;
    } else {
      shape = `<path d="M0 ${vh * 0.75} L${vw * 0.2} ${vh * 0.53} L${vw * 0.37} ${vh * 0.67} L${vw * 0.6} ${vh * 0.35} L${vw} ${vh * 0.58}" stroke="${color2}" stroke-width="2" fill="none" opacity="0.55"/>`;
    }

    preview.innerHTML = `<rect width="${vw}" height="${vh}" fill="${color1}"/>${shape}`;
  }

  if (preview) {
    [c1, c2].forEach((el) => el && el.addEventListener('input', renderArtPreview));
    patternInputs.forEach((el) => el.addEventListener('change', renderArtPreview));
    renderArtPreview();
  }

  // Auto-generate slug dari judul kalau field slug masih kosong
  const titleInput = document.getElementById('titleInput');
  const slugInput = document.getElementById('slugInput');
  if (titleInput && slugInput) {
    let slugTouched = slugInput.value.trim().length > 0;
    slugInput.addEventListener('input', () => { slugTouched = true; });
    titleInput.addEventListener('input', () => {
      if (slugTouched) return;
      slugInput.value = titleInput.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    });
  }
});
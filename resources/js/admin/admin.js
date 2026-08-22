// EdukaVisionNews — Admin panel JS (ringan, tanpa framework)

document.addEventListener('DOMContentLoaded', () => {
  // Konfirmasi sebelum menghapus data (berita, kategori, iklan)
  document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      const msg = form.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
      if (!window.confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // Preview gambar iklan sebelum diupload
  const imageInput = document.getElementById('adImageInput');
  const imagePreview = document.getElementById('adImagePreview');
  if (imageInput && imagePreview) {
    imageInput.addEventListener('change', () => {
      const file = imageInput.files && imageInput.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
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

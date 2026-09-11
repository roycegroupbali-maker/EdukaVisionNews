/* Overlay pencarian artikel: index dibangun otomatis dari kartu-kartu di halaman */
export function initSearch() {
  const searchBtn = document.getElementById('searchBtn');
  const searchOverlay = document.getElementById('searchOverlay');
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');
  const searchClose = document.getElementById('searchClose');

  if (!searchBtn || !searchOverlay || !searchInput || !searchResults || !searchClose) return;

  // Judul/kategori diambil dari textContent kartu di halaman, jadi bisa berisi
  // karakter HTML kalau judul artikel memuat karakter seperti < atau &.
  // Wajib di-escape sebelum ditulis lewat innerHTML supaya tidak jadi celah XSS.
  function escapeHtml(str) {
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function buildIndex() {
    const els = document.querySelectorAll(
      'a.card, a.side-item, a.feature-card, a.recipe-card, a.stacked-card, a.recipe-feature'
    );
    const items = [];
    els.forEach((el) => {
      const titleEl = el.querySelector('.card-title, .side-title, .feature-headline, .display');
      const tagEl = el.querySelector('.tag');
      const section = el.closest('section[id]');
      if (!titleEl) return;
      items.push({
        title: titleEl.textContent.trim(),
        cat: tagEl ? tagEl.textContent.trim() : 'Umum',
        href: section ? '#' + section.id : '#',
      });
    });
    return items;
  }

  const searchIndex = buildIndex();

  function openSearch() {
    searchOverlay.classList.add('open');
    searchInput.focus();
  }

  function closeSearch() {
    searchOverlay.classList.remove('open');
    searchInput.value = '';
    renderResults('');
  }

  function renderResults(q) {
    q = q.trim().toLowerCase();
    if (!q) {
      searchResults.innerHTML =
        '<p class="search-hint">Ketik kata kunci untuk mencari di seluruh artikel pada halaman ini.</p>';
      return;
    }
    const matches = searchIndex
      .filter((it) => it.title.toLowerCase().indexOf(q) !== -1)
      .slice(0, 8);
    if (matches.length === 0) {
      searchResults.innerHTML =
        '<p class="search-empty">Tidak ditemukan artikel yang cocok dengan "' +
        escapeHtml(q) +
        '".</p>';
      return;
    }
    searchResults.innerHTML = matches
      .map(
        (m) =>
          '<a href="' +
          m.href +
          '" class="search-result-item"><span class="search-result-cat">' +
          escapeHtml(m.cat) +
          '</span><span>' +
          escapeHtml(m.title) +
          '</span></a>'
      )
      .join('');
  }

  searchBtn.addEventListener('click', openSearch);
  searchClose.addEventListener('click', closeSearch);
  searchOverlay.addEventListener('click', (e) => {
    if (e.target === searchOverlay) closeSearch();
  });
  searchInput.addEventListener('input', function () {
    renderResults(this.value);
  });
  searchResults.addEventListener('click', (e) => {
    if (e.target.closest('.search-result-item')) setTimeout(closeSearch, 80);
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && searchOverlay.classList.contains('open')) closeSearch();
    if (e.key === '/' && document.activeElement !== searchInput && !searchOverlay.classList.contains('open')) {
      e.preventDefault();
      openSearch();
    }
  });
}
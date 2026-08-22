/* Strip kategori (scroll ke section) + scrollspy untuk menandai menu aktif */
export function initNavAndScrollspy() {
  const catButtons = document.querySelectorAll('.catstrip button');
  catButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-jump');
      if (target) {
        const el = document.getElementById(target);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('nav.primary a');

  if ('IntersectionObserver' in window && sections.length) {
    const spy = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const id = entry.target.id;
          navLinks.forEach((l) => l.classList.toggle('active', l.getAttribute('href') === '#' + id));
          catButtons.forEach((b) => b.classList.toggle('active', b.getAttribute('data-jump') === id));
        });
      },
      { rootMargin: '-35% 0px -55% 0px' }
    );
    sections.forEach((s) => spy.observe(s));
  }
}

/* Tab "Sedang Tren": Terpopuler / Terbaru / Terkomentar */
export function initTrendingTabs() {
  const trendTabs = document.querySelectorAll('.trend-tab');
  const trendPanels = document.querySelectorAll('.trend-panel');
  if (!trendTabs.length) return;

  trendTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      trendTabs.forEach((t) => t.classList.remove('active'));
      trendPanels.forEach((p) => p.classList.remove('active'));
      tab.classList.add('active');
      const panel = document.getElementById(tab.getAttribute('data-panel'));
      if (panel) panel.classList.add('active');
    });
  });
}

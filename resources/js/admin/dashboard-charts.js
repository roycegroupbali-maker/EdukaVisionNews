// EdukaVisionNews — Grafik dashboard admin (Chart.js, dibundel lewat Vite, tanpa CDN luar)
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
  const dataEl = document.getElementById('dashboard-chart-data');
  if (!dataEl) return;

  let data;
  try {
    data = JSON.parse(dataEl.textContent);
  } catch (e) {
    console.error('Gagal membaca data grafik dashboard:', e);
    return;
  }

  const inkColor   = '#0D1B3A';
  const pulseColor = '#C1272D';
  const goldColor  = '#B28923';
  const mutedColor = '#6B6558';
  const gridColor  = 'rgba(13,27,58,0.08)';

  Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
  Chart.defaults.color = mutedColor;

  // 1) Views & Shares per Kategori (grouped bar)
  const catCanvas = document.getElementById('chartViewsPerCategory');
  if (catCanvas) {
    new Chart(catCanvas, {
      type: 'bar',
      data: {
        labels: data.categoryLabels,
        datasets: [
          { label: 'Views', data: data.categoryViews, backgroundColor: pulseColor, borderRadius: 6, maxBarThickness: 34 },
          { label: 'Shares', data: data.categoryShares, backgroundColor: goldColor, borderRadius: 6, maxBarThickness: 34 },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top', align: 'end', labels: { boxWidth: 12, boxHeight: 12, usePointStyle: true, pointStyle: 'circle' } },
          tooltip: { backgroundColor: inkColor, padding: 10, cornerRadius: 8 },
        },
        scales: {
          x: { grid: { display: false }, ticks: { font: { size: 11.5 } } },
          y: { beginAtZero: true, grid: { color: gridColor }, ticks: { precision: 0 } },
        },
      },
    });
  }

  // 2) Berita Paling Banyak Dibaca (horizontal bar)
  const mvCanvas = document.getElementById('chartMostViewed');
  if (mvCanvas) {
    const fullTitles = data.mostViewedTitles;
    const shortTitles = fullTitles.map((t) => (t.length > 28 ? t.slice(0, 28) + '...' : t));

    new Chart(mvCanvas, {
      type: 'bar',
      data: {
        labels: shortTitles,
        datasets: [{ label: 'Views', data: data.mostViewedViews, backgroundColor: inkColor, borderRadius: 6, maxBarThickness: 22 }],
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: inkColor,
            padding: 10,
            cornerRadius: 8,
            callbacks: { title: (items) => fullTitles[items[0].dataIndex] },
          },
        },
        scales: {
          x: { beginAtZero: true, grid: { color: gridColor }, ticks: { precision: 0 } },
          y: { grid: { display: false }, ticks: { font: { size: 11.5 } } },
        },
      },
    });
  }

  // 3) Komposisi Views per Kategori (doughnut)
  const donutCanvas = document.getElementById('chartCategoryDonut');
  if (donutCanvas) {
    const palette = ['#C1272D', '#B28923', '#0D1B3A', '#5B8C5A', '#3A6EA5', '#8f5fb0', '#c17a3e', '#4e8f8b'];

    new Chart(donutCanvas, {
      type: 'doughnut',
      data: {
        labels: data.categoryLabels,
        datasets: [{
          data: data.categoryViews,
          backgroundColor: data.categoryLabels.map((_, i) => palette[i % palette.length]),
          borderColor: '#fff',
          borderWidth: 2,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '62%',
        plugins: {
          legend: { position: 'bottom', labels: { boxWidth: 10, boxHeight: 10, usePointStyle: true, pointStyle: 'circle', font: { size: 11.5 } } },
          tooltip: { backgroundColor: inkColor, padding: 10, cornerRadius: 8 },
        },
      },
    });
  }
});

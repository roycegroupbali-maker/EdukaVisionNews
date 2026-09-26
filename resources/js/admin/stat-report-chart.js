// EdukaVisionNews — Grafik tren Laporan Statistik (Chart.js, dibundel lewat Vite)
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
  const dataEl = document.getElementById('stat-trend-data');
  const canvas = document.getElementById('chartStatTrend');
  if (!dataEl || !canvas) return;

  let data;
  try {
    data = JSON.parse(dataEl.textContent);
  } catch (e) {
    console.error('Gagal membaca data grafik statistik:', e);
    return;
  }

  const pulseColor = '#C1272D';
  const goldColor = '#B28923';
  const inkColor = '#0D1B3A';
  const mutedColor = '#6B6558';
  const gridColor = 'rgba(13,27,58,0.08)';

  Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
  Chart.defaults.color = mutedColor;

  new Chart(canvas, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [
        {
          label: 'Views',
          data: data.views,
          borderColor: pulseColor,
          backgroundColor: 'rgba(193,39,45,0.08)',
          tension: 0.3,
          fill: true,
          pointRadius: 2,
        },
        {
          label: 'Share',
          data: data.shares,
          borderColor: goldColor,
          backgroundColor: 'rgba(178,137,35,0.08)',
          tension: 0.3,
          fill: true,
          pointRadius: 2,
        },
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
        x: { grid: { display: false }, ticks: { font: { size: 11 }, maxRotation: 0, autoSkip: true } },
        y: { beginAtZero: true, grid: { color: gridColor }, ticks: { precision: 0 } },
      },
    },
  });
});

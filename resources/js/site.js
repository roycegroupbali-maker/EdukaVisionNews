/* ==========================================================================
   EdukaVisionNews — Site Script (entry point)
   File ini hanya mengimpor & menjalankan modul-modul fitur dari folder
   modules/. Untuk menambah fitur baru, buat file baru di modules/,
   lalu import + panggil di sini.
   ========================================================================== */

import { initReadingProgress } from './modules/reading-progress.js';
import { initLiveClock } from './modules/live-clock.js';
import { initThemeToggle } from './modules/theme-toggle.js';
import { initSearch } from './modules/search.js';
import { initNavAndScrollspy } from './modules/nav-scrollspy.js';
import { initTrendingTabs } from './modules/trending-tabs.js';
import { initPoll } from './modules/poll.js';
import {
  initLoadMore,
  initBackToTop,
  initBookmarkButton,
  initMobileAdDismiss,
} from './modules/misc-widgets.js';
import { initAccessibilityWidget } from './modules/accessibility.js';
import { initArticleShare } from './modules/article-share.js';

function initSite() {
  initReadingProgress();
  initLiveClock();
  initThemeToggle();
  initSearch();
  initNavAndScrollspy();
  initTrendingTabs();
  initPoll();
  initLoadMore();
  initBackToTop();
  initBookmarkButton();
  initMobileAdDismiss();
  initAccessibilityWidget();
  initArticleShare();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSite);
} else {
  initSite();
}

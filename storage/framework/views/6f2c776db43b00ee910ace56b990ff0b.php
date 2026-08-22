<!-- ============ ACCESSIBILITY TOOLS ============ -->
<button class="a11y-toggle" id="a11yToggle" aria-label="Buka alat bantu aksesibilitas" aria-expanded="false" title="Alat Bantu Aksesibilitas">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" stroke="none">
    <circle cx="12" cy="4.2" r="2.1"/>
    <path d="M4.3 7.6c-.6.15-1 .77-.83 1.4.15.6.77 1 1.4.83L11 8.4v2.9L7.2 20a1.15 1.15 0 0 0 2.1.95l2.7-6 2.7 6a1.15 1.15 0 0 0 2.1-.95L13 11.3V8.4l6.13 1.43c.6.15 1.23-.23 1.4-.83.16-.63-.23-1.25-.83-1.4L13 6.1h-2z"/>
  </svg>
</button>

<div class="a11y-overlay" id="a11yOverlay"></div>

<aside class="a11y-panel" id="a11yPanel" role="dialog" aria-modal="true" aria-labelledby="a11yPanelTitle">
  <div class="a11y-panel-head">
    <h2 id="a11yPanelTitle">Accessibility Tools</h2>
    <button class="a11y-close" id="a11yClose" aria-label="Tutup alat bantu aksesibilitas">✕</button>
  </div>

  <div class="a11y-panel-body">

    <section class="a11y-group">
      <h3>ADHD Mode</h3>
      <div class="a11y-row a11y-row-1">
        <button type="button" class="a11y-btn" data-toggle="adhd" data-icon="brain">
          <span class="a11y-icon">🧠</span><span>Enable</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Font Size</h3>
      <div class="a11y-row a11y-row-2">
        <button type="button" class="a11y-btn" data-action="font-smaller">
          <span class="a11y-icon a11y-icon-font">A<sup>−</sup></span><span>Smaller</span>
        </button>
        <button type="button" class="a11y-btn" data-action="font-bigger">
          <span class="a11y-icon a11y-icon-font">A<sup>+</sup></span><span>Bigger</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Text Alignment</h3>
      <div class="a11y-row a11y-row-4">
        <button type="button" class="a11y-btn" data-select="align" data-value="left">
          <span class="a11y-icon">≡</span><span>Left</span>
        </button>
        <button type="button" class="a11y-btn" data-select="align" data-value="center">
          <span class="a11y-icon">≡</span><span>Center</span>
        </button>
        <button type="button" class="a11y-btn" data-select="align" data-value="right">
          <span class="a11y-icon">≡</span><span>Right</span>
        </button>
        <button type="button" class="a11y-btn" data-select="align" data-value="justify">
          <span class="a11y-icon">≡</span><span>Justify</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Line Height</h3>
      <div class="a11y-row a11y-row-2">
        <button type="button" class="a11y-btn" data-select="lineheight" data-value="tight">
          <span class="a11y-icon">↕</span><span>Tight</span>
        </button>
        <button type="button" class="a11y-btn" data-select="lineheight" data-value="wide">
          <span class="a11y-icon">↕</span><span>Wide</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Letter Spacing</h3>
      <div class="a11y-row a11y-row-3">
        <button type="button" class="a11y-btn" data-select="letterspacing" data-value="normal">
          <span class="a11y-icon">↔</span><span>Normal</span>
        </button>
        <button type="button" class="a11y-btn" data-select="letterspacing" data-value="medium">
          <span class="a11y-icon">↔</span><span>Medium</span>
        </button>
        <button type="button" class="a11y-btn" data-select="letterspacing" data-value="wide">
          <span class="a11y-icon">↔</span><span>Wide</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Saturation</h3>
      <div class="a11y-row a11y-row-1">
        <button type="button" class="a11y-btn" data-toggle="lowcolor">
          <span class="a11y-icon">💧</span><span>Low Color</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Contrast</h3>
      <div class="a11y-row a11y-row-1">
        <button type="button" class="a11y-btn" data-toggle="contrast">
          <span class="a11y-icon">◐</span><span>High</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Reading Mask</h3>
      <div class="a11y-row a11y-row-1">
        <button type="button" class="a11y-btn" data-toggle="readingmask">
          <span class="a11y-icon">✏️</span><span>Enable</span>
        </button>
      </div>
    </section>

    <section class="a11y-group">
      <h3>Dyslexia Mode</h3>
      <div class="a11y-row a11y-row-1">
        <button type="button" class="a11y-btn" data-toggle="dyslexia">
          <span class="a11y-icon a11y-icon-font">A</span><span>Enable</span>
        </button>
      </div>
    </section>

  </div>

  <div class="a11y-panel-foot">
    <button type="button" class="a11y-reset" id="a11yReset">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg>
      Reset All
    </button>
  </div>
</aside>

<div class="a11y-reading-mask" id="a11yReadingMask"></div>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/accessibility-widget.blade.php ENDPATH**/ ?>
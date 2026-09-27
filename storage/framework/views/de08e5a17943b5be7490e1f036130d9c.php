<?php echo $__env->make('partials.header', ['pageTitle' => 'EdukaVisionNews — Denyut Kabar Hari Ini'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- ============ LEADERBOARD AD ============ -->
<div class="section-band">
  <div class="wrap">
    <?php echo $__env->make('partials.ad-slot', ['slot' => 'leaderboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</div>

<!-- ============ HERO ============ -->
<?php if($hero): ?>
<section class="hero section-band">
  <div class="wrap hero-grid">
    <a href="<?php echo e(route('article.show', $hero->slug)); ?>" class="feature-card">
      <div class="feature-art">
        <button class="bookmark-btn" aria-label="Simpan artikel" onclick="event.preventDefault()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M6 3a2 2 0 0 0-2 2v16l8-5 8 5V5a2 2 0 0 0-2-2H6z"/></svg>
        </button>
        <?php echo $__env->make('partials.art', ['article' => $hero, 'viewbox' => '0 0 640 400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <span class="tag <?php echo e($hero->category->tag_class); ?>"><?php echo e($hero->subcategory ?? $hero->category->name); ?></span>
      <h1 class="feature-headline display"><?php echo e($hero->title); ?></h1>
      <p class="feature-dek"><?php echo e($hero->excerpt); ?></p>
      <span class="byline"><?php echo e(strtoupper($hero->author)); ?> · <?php echo e($hero->read_minutes); ?> MENIT BACA</span>
    </a>

    <div class="side-list">
      <?php $__currentLoopData = $sideList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $s, 'variant' => 'side'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H480 L505 6 L525 40 L545 23 H1240"/>
  <circle cx="525" cy="23" r="4"/>
</svg>

<!-- ============ TRENDING + SIDEBAR AD ============ -->
<section class="section-band alt">
  <div class="wrap trend-ad-grid">
    <div class="trend-widget">
      <div class="trend-widget-head">
        <h3><span class="bar"></span> Sedang Tren</h3>
      </div>
      <div class="trend-tabs">
        <button class="trend-tab active" data-panel="trendPopuler">Terpopuler</button>
        <button class="trend-tab" data-panel="trendTerbaru">Terbaru</button>
      </div>
      <div class="trend-panel active" id="trendPopuler">
        <?php $__currentLoopData = $trending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('article.show', $t->slug)); ?>" class="trend-item"><span class="trend-rank"><?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span><span class="trend-title"><?php echo e($t->title); ?></span></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="trend-panel" id="trendTerbaru">
        <?php $__currentLoopData = $latest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('article.show', $t->slug)); ?>" class="trend-item"><span class="trend-rank"><?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span><span class="trend-title"><?php echo e($t->title); ?></span></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <?php echo $__env->make('partials.ad-slot', ['slot' => 'rectangle'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</section>

<?php
    $berita = $sections->get('berita', collect());
    $dunia = $sections->get('dunia', collect());
    $bisnis = $sections->get('bisnis', collect());
    $olahraga = $sections->get('olahraga', collect());
    $lifestyle = $sections->get('lifestyle', collect());
    $edukasi = $sections->get('edukasi', collect());
    $resep = $sections->get('resep', collect());
?>

<!-- ============ BERITA TERKINI ============ -->
<?php if($berita->count()): ?>
<section class="section-band" id="berita">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Berita Terkini</h2>
      <a href="<?php echo e(route('category.show', 'berita')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4">
      <?php $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ DUNIA / INTERNASIONAL ============ -->
<?php if($dunia->count()): ?>
<section class="section-band alt" id="dunia">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--violet);"></span> Dunia</h2>
      <a href="<?php echo e(route('category.show', 'dunia')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="world-strip">
      <?php $__currentLoopData = $dunia->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $a, 'variant' => $i === 0 ? 'big' : 'default'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H520 L540 8 L558 38 L572 15 H1240"/>
  <circle cx="558" cy="38" r="4"/>
</svg>

<!-- ============ BISNIS & EKONOMI ============ -->
<?php if($bisnis->count()): ?>
<section class="section-band" id="bisnis">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--ink);"></span> Ekonomi &amp; Bisnis</h2>
      <a href="<?php echo e(route('category.show', 'bisnis')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4 grid-4-foot">
      <?php $__currentLoopData = $bisnis->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php echo $__env->make('partials.ad-slot', ['slot' => 'midpage'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ OLAHRAGA ============ -->
<?php if($olahraga->count()): ?>
<section class="section-band alt" id="olahraga">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--navy2);"></span> Olahraga</h2>
      <a href="<?php echo e(route('category.show', 'olahraga')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>

    <div class="grid-4 grid-4-foot">
      <?php $__currentLoopData = $olahraga->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ LIFESTYLE ============ -->
<?php if($lifestyle->count()): ?>
<section class="section-band" id="lifestyle">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--teal);"></span> Lifestyle</h2>
      <a href="<?php echo e(route('category.show', 'lifestyle')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <?php $lsChunks = $lifestyle->skip(1)->take(6)->chunk(3); ?>
    <div class="split-3">
      <?php if($lifestyle->first()): ?>
        <?php echo $__env->make('partials.card', ['article' => $lifestyle->first(), 'variant' => 'big'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endif; ?>
      <?php $__currentLoopData = $lsChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="stack-col">
          <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.card', ['article' => $a, 'variant' => 'stacked'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ EDUKASI ============ -->
<?php if($edukasi->count()): ?>
<section class="section-band alt" id="edukasi">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--gold-deep);"></span> Edukasi</h2>
      <a href="<?php echo e(route('category.show', 'edukasi')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="grid-4 grid-4-foot">
      <?php $__currentLoopData = $edukasi->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Pulse divider -->
<svg class="pulse-divider" viewBox="0 0 1240 46" preserveAspectRatio="none">
  <path d="M0 23 H340 L360 8 L378 38 L392 15 L410 23 H1240"/>
  <circle cx="378" cy="38" r="4"/>
</svg>

<!-- ============ RESEP MASAKAN ============ -->
<?php if($resep->count()): ?>
<section class="section-band" id="resep">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:var(--rust);"></span> Resep Masakan</h2>
      <a href="<?php echo e(route('category.show', 'resep')); ?>" class="section-link">Lihat semua <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>

    <?php if($resep->first()): ?>
      <?php echo $__env->make('partials.recipe-card', ['article' => $resep->first(), 'variant' => 'feature'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <div class="grid-3-recipe">
      <?php $__currentLoopData = $resep->skip(1)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.recipe-card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ JAJAK PENDAPAT ============ -->
<section class="section-band alt poll-section">
  <div class="wrap">
    <div class="poll-widget">
      <span class="tag">Jajak Pendapat Pembaca</span>
      <h3 class="poll-question">Topik apa yang paling ingin kamu baca lebih banyak minggu ini?</h3>
      <button class="poll-option" data-opt="opt1">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Perkembangan ekonomi &amp; bisnis lokal</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt2">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Pendidikan &amp; beasiswa</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt3">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Resep &amp; kuliner Nusantara</span><span class="poll-pct">0%</span></div>
      </button>
      <button class="poll-option" data-opt="opt4">
        <div class="poll-fill"></div>
        <div class="poll-option-row"><span>Olahraga nasional</span><span class="poll-pct">0%</span></div>
      </button>
      <div class="poll-meta">
        <span id="pollNote">Pilih satu jawaban untuk melihat hasil sementara.</span>
        <span><span id="pollTotal">1.284</span> suara</span>
      </div>
    </div>
  </div>
</section>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH D:\web\EdukaVisionNews\resources\views/home.blade.php ENDPATH**/ ?>
<?php echo $__env->make('partials.header', [
    'pageTitle' => $article->title . ' — EdukaVisionNews',
    'pageDescription' => $article->excerpt,
    'ogType' => 'article',
    'ogPublishedTime' => $article->published_at?->toIso8601String(),
    'ogSection' => $article->category->name,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script type="application/ld+json">
<?php echo json_encode([
    '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $article->title,
    'description' => $article->excerpt,
    'datePublished' => $article->published_at?->toIso8601String(),
    'dateModified' => $article->updated_at?->toIso8601String(),
    'author' => ['@type' => 'Person', 'name' => $article->author],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'EdukaVisionNews',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
    'articleSection' => $article->category->name,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>

<div class="section-band">
  <div class="wrap">
    <?php echo $__env->make('partials.ad-slot', ['slot' => 'leaderboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</div>

<article class="section-band article-detail">
  <div class="wrap" style="max-width:760px;">

    <nav style="font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.04em; margin-bottom:18px; color:var(--ink-soft, #667);">
      <a href="<?php echo e(route('home')); ?>">Beranda</a>
      &nbsp;/&nbsp;
      <a href="<?php echo e(route('category.show', $article->category->slug)); ?>"><?php echo e($article->category->name); ?></a>
    </nav>

    <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 12px;"><?php echo e($article->title); ?></h1>
    <p class="feature-dek" style="font-size:18px; margin-bottom:16px;"><?php echo e($article->excerpt); ?></p>

    <div class="byline" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:22px;">
      <span><?php echo e(strtoupper($article->author)); ?></span>
      <span>·</span>
      <span><?php echo e($article->readable_date); ?></span>
      <span>·</span>
      <span><?php echo e($article->read_minutes); ?> MENIT BACA</span>
      <span>·</span>
      <span><?php echo e(number_format($article->views)); ?> DIBACA</span>
    </div>

    <div class="feature-art" style="aspect-ratio:16/9; margin-bottom:26px; border-radius:10px; overflow:hidden;">
      <?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 640 400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="article-body" style="font-family:'Fraunces', serif; font-size:18px; line-height:1.8; color:var(--ink,#1a1a1a);">
      <?php $__currentLoopData = $article->paragraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p style="margin-bottom:20px;"><?php echo e($p); ?></p>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($article->category->slug === 'resep' && ($article->recipe_minutes || $article->recipe_servings)): ?>
      <div class="recipe-meta" style="margin-top:10px;">
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_minutes ?? '-'); ?></span><span class="lbl">Menit</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_servings ?? '-'); ?></span><span class="lbl">Porsi</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_difficulty ?? '-'); ?></span><span class="lbl">Tingkat</span></div>
      </div>
    <?php endif; ?>

    <div style="margin-top:34px;">
      <?php echo $__env->make('partials.ad-slot', ['slot' => 'midpage'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
  </div>
</article>

<?php if($related->count()): ?>
<section class="section-band alt">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Artikel Terkait</h2>
    </div>
    <div class="grid-4">
      <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.card', ['article' => $r], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/articles/show.blade.php ENDPATH**/ ?>
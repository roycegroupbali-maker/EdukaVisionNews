<?php echo $__env->make('partials.header', [
    'pageTitle' => $category->name . ' — EdukaVisionNews',
    'pageDescription' => 'Kumpulan berita terbaru kategori ' . $category->name . ' dari EdukaVisionNews.',
    'ogKeywords' => $category->name . ', berita ' . strtolower($category->name) . ', EdukaVisionNews',
    'breadcrumbs' => [
        ['name' => 'Beranda', 'url' => route('home')],
        ['name' => $category->name, 'url' => route('category.show', $category->slug)],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="section-band">
  <div class="wrap">
    <?php echo $__env->make('partials.ad-slot', ['slot' => 'leaderboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
</div>

<section class="section-band">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:<?php echo e($category->bar_color); ?>;"></span> <?php echo e($category->name); ?></h2>
    </div>

    <?php if($articles->isEmpty()): ?>
      <p style="font-family:'IBM Plex Mono',monospace; opacity:.7;">Belum ada artikel di kategori ini.</p>
    <?php else: ?>
      <div class="grid-4">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo $__env->make('partials.card', ['article' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div class="load-more-row">
        <?php echo e($articles->links()); ?>

      </div>
    <?php endif; ?>
  </div>
</section>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/categories/show.blade.php ENDPATH**/ ?>
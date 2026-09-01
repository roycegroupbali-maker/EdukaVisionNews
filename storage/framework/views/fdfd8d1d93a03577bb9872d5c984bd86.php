<?php echo $__env->make('partials.header', [
    'pageTitle' => 'Hasil Pencarian: ' . $query . ' — EdukaVisionNews',
    'query' => $query,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="section-band">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Hasil Pencarian <?php if($query): ?>"<?php echo e($query); ?>"<?php endif; ?></h2>
    </div>

    <p style="font-family:'IBM Plex Mono',monospace; font-size:13px; opacity:.7; margin-bottom:20px;">
      <?php echo e($articles->total()); ?> artikel ditemukan
    </p>

    <?php if($articles->isEmpty()): ?>
      <p style="font-family:'IBM Plex Mono',monospace; opacity:.7;">Tidak ada artikel yang cocok dengan kata kunci tersebut. Coba kata kunci lain.</p>
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/search.blade.php ENDPATH**/ ?>
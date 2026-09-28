<?php $variant = $variant ?? 'small'; ?>

<?php if($variant === 'feature'): ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="recipe-feature">
    <div class="recipe-feature-art"><?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 500 400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <div class="recipe-feature-body">
      <span class="tag resep"><?php echo e($article->subcategory ?? 'Resep Pilihan Hari Ini'); ?></span>
      <h3 class="display"><?php echo e($article->title); ?></h3>
      <p><?php echo e($article->excerpt); ?></p>
      <div class="recipe-meta">
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_minutes ?? 30); ?></span><span class="lbl">Menit</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_servings ?? 4); ?></span><span class="lbl">Porsi</span></div>
        <div class="recipe-meta-item"><span class="num"><?php echo e($article->recipe_difficulty ?? 'Mudah'); ?></span><span class="lbl">Tingkat</span></div>
      </div>
    </div>
  </a>
<?php else: ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="recipe-card">
    <div class="recipe-card-art"><?php echo $__env->make('partials.art', ['article' => $article], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <div class="recipe-card-body">
      <span class="tag resep"><?php echo e($article->subcategory ?? 'Resep'); ?></span>
      <h3 class="card-title"><?php echo e($article->title); ?></h3>
      <p class="card-dek"><?php echo e($article->excerpt); ?></p>
      <div class="recipe-time"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg> <?php echo e($article->recipe_minutes ?? 30); ?> menit · <?php echo e($article->recipe_servings ?? 4); ?> porsi</div>
    </div>
  </a>
<?php endif; ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/recipe-card.blade.php ENDPATH**/ ?>

<?php $variant = $variant ?? 'default'; ?>

<?php if($variant === 'side'): ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="side-item">
    <div class="side-thumb"><?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 100 100'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <div>
      <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
      <p class="side-title"><?php echo e($article->title); ?></p>
      <span class="side-meta"><?php echo e($article->read_minutes); ?> MENIT BACA</span>
    </div>
  </a>

<?php elseif($variant === 'stacked'): ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="stacked-card">
    <div class="stacked-thumb"><?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 110 80'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <div>
      <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
      <p class="card-title" style="font-size:15.5px; margin:6px 0 4px;"><?php echo e($article->title); ?></p>
      <span class="byline"><?php echo e($article->read_minutes); ?> MENIT BACA</span>
    </div>
  </a>

<?php elseif($variant === 'big'): ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="card big-card">
    <div class="card-art"><?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 300 232'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
    <h3 class="card-title"><?php echo e($article->title); ?></h3>
    <p class="card-dek"><?php echo e($article->excerpt); ?></p>
    <span class="byline"><?php echo e($article->read_minutes); ?> MENIT BACA</span>
  </a>

<?php else: ?>
  <a href="<?php echo e(route('article.show', $article->slug)); ?>" class="card <?php echo e($class ?? ''); ?>">
    <div class="card-art"><?php echo $__env->make('partials.art', ['article' => $article], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <span class="tag <?php echo e($article->category->tag_class); ?>"><?php echo e($article->subcategory ?? $article->category->name); ?></span>
    <h3 class="card-title"><?php echo e($article->title); ?></h3>
    <p class="card-dek"><?php echo e($article->excerpt); ?></p>
    <span class="byline"><?php echo e($article->read_minutes); ?> MENIT BACA</span>
  </a>
<?php endif; ?>
<?php /**PATH D:\web\EdukaVisionNews\resources\views/partials/card.blade.php ENDPATH**/ ?>
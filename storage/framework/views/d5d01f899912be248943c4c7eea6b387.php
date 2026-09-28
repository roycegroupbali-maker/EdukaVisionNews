
<?php
    $__ad = ($ads[$slot] ?? null);
    $__type = $type ?? $slot;
?>

<?php if($__type === 'leaderboard'): ?>
  <div class="ad-leaderboard">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__ad): ?>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" style="display:block; width:100%; max-width:640px;">
        <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="width:100%; border-radius:4px;">
      </a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Leaderboard · 970 × 90</span>
      <span class="ad-note">Slot iklan header — tayang di semua halaman utama</span>
    <?php endif; ?>
  </div>
<?php elseif($__type === 'rectangle'): ?>
  <div class="ad-rect">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__ad): ?>
      <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="width:100%; border-radius:6px; margin-top:4px;">
      <span class="ad-creative"><?php echo e($__ad->title); ?></span>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" class="ad-cta"><?php echo e($__ad->cta_text ?: 'Pelajari Selengkapnya'); ?></a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Rectangle · 300 × 600</span>
      <span class="ad-note">Menyesuaikan tinggi widget di sebelahnya</span>
      <span class="ad-cta">Pelajari Selengkapnya</span>
    <?php endif; ?>
  </div>
<?php elseif($__type === 'midpage'): ?>
  <div class="ad-midpage">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__ad): ?>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" style="display:block; width:100%; max-width:520px;">
        <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="width:100%; border-radius:4px;">
      </a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Tengah Halaman · 728 × 250</span>
    <?php endif; ?>
  </div>
<?php endif; ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/ad-slot.blade.php ENDPATH**/ ?>
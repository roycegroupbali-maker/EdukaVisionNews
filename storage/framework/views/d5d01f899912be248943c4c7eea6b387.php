
<?php
    $__ad = ($ads[$slot] ?? null);
    $__type = $type ?? $slot;
    $__ratio = \App\Models\Ad::SLOT_RATIOS[$__type] ?? \App\Models\Ad::SLOT_RATIOS['leaderboard'];
    $__frame = "--ad-ratio:{$__ratio['desktop']}; --ad-ratio-m:{$__ratio['mobile']};";
    $__hasImage = $__ad && $__ad->image_url;
?>

<?php if($__type === 'leaderboard'): ?>
  <div class="ad-leaderboard <?php echo e($__hasImage ? 'has-image' : ''); ?>">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__hasImage): ?>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" class="ad-frame" style="<?php echo e($__frame); ?>">
        <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="<?php echo e($__ad->image_style); ?>">
      </a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Leaderboard · 970 × 90</span>
      <span class="ad-note">Slot iklan header — tayang di semua halaman utama</span>
    <?php endif; ?>
  </div>
<?php elseif($__type === 'rectangle'): ?>
  <div class="ad-rect <?php echo e($__hasImage ? 'has-image' : ''); ?>">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__hasImage): ?>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" class="ad-frame" style="<?php echo e($__frame); ?>">
        <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="<?php echo e($__ad->image_style); ?>">
      </a>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" class="ad-cta" style="align-self:center;"><?php echo e($__ad->cta_text ?: 'Pelajari Selengkapnya'); ?></a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Rectangle · 300 × 600</span>
      <span class="ad-note">Menyesuaikan tinggi widget di sebelahnya</span>
      <span class="ad-cta">Pelajari Selengkapnya</span>
    <?php endif; ?>
  </div>
<?php elseif($__type === 'midpage'): ?>
  <div class="ad-midpage <?php echo e($__hasImage ? 'has-image' : ''); ?>">
    <span class="ad-eyebrow">Iklan</span>
    <?php if($__hasImage): ?>
      <a href="<?php echo e(route('ads.click', $__ad)); ?>" target="_blank" rel="noopener sponsored" class="ad-frame" style="<?php echo e($__frame); ?>">
        <img src="<?php echo e($__ad->image_url); ?>" alt="<?php echo e($__ad->title); ?>" style="<?php echo e($__ad->image_style); ?>">
      </a>
    <?php else: ?>
      <span class="ad-creative">Ruang Iklan Tengah Halaman · 728 × 250</span>
    <?php endif; ?>
  </div>
<?php endif; ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/ad-slot.blade.php ENDPATH**/ ?>
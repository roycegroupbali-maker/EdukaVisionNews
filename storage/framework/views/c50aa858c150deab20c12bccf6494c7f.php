
<?php
    $vb = $viewbox ?? '0 0 300 225';
    [$vx, $vy, $vw, $vh] = array_map('intval', explode(' ', $vb));
    $c1 = $article->art_color1;
    $c2 = $article->art_color2;
    $pattern = $article->art_pattern;
?>
<svg viewBox="<?php echo e($vb); ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
  <rect width="<?php echo e($vw); ?>" height="<?php echo e($vh); ?>" fill="<?php echo e($c1); ?>"/>
  <?php switch($pattern):
    case ('circles'): ?>
      <circle cx="<?php echo e($vw * 0.7); ?>" cy="<?php echo e($vh * 0.35); ?>" r="<?php echo e($vh * 0.3); ?>" fill="<?php echo e($c2); ?>" opacity="0.5"/>
      <circle cx="<?php echo e($vw * 0.7); ?>" cy="<?php echo e($vh * 0.35); ?>" r="<?php echo e($vh * 0.15); ?>" fill="<?php echo e($c2); ?>" opacity="0.4"/>
      <?php break; ?>
    <?php case ('triangle'): ?>
      <path d="M<?php echo e($vw * 0.2); ?> <?php echo e($vh * 0.8); ?> L<?php echo e($vw * 0.5); ?> <?php echo e($vh * 0.25); ?> L<?php echo e($vw * 0.8); ?> <?php echo e($vh * 0.8); ?> Z" fill="<?php echo e($c2); ?>" opacity="0.35"/>
      <?php break; ?>
    <?php case ('grid'): ?>
      <rect x="<?php echo e($vw * 0.23); ?>" y="<?php echo e($vh * 0.3); ?>" width="<?php echo e($vw * 0.54); ?>" height="<?php echo e($vh * 0.42); ?>" rx="6" fill="none" stroke="<?php echo e($c2); ?>" stroke-width="1.5" opacity="0.4"/>
      <?php break; ?>
    <?php case ('dots'): ?>
      <circle cx="<?php echo e($vw * 0.35); ?>" cy="<?php echo e($vh * 0.5); ?>" r="4" fill="<?php echo e($c2); ?>" opacity="0.6"/>
      <circle cx="<?php echo e($vw * 0.5); ?>" cy="<?php echo e($vh * 0.4); ?>" r="4" fill="<?php echo e($c2); ?>" opacity="0.6"/>
      <circle cx="<?php echo e($vw * 0.65); ?>" cy="<?php echo e($vh * 0.55); ?>" r="4" fill="<?php echo e($c2); ?>" opacity="0.6"/>
      <path d="M<?php echo e($vw * 0.35); ?> <?php echo e($vh * 0.5); ?> L<?php echo e($vw * 0.5); ?> <?php echo e($vh * 0.4); ?> L<?php echo e($vw * 0.65); ?> <?php echo e($vh * 0.55); ?>" stroke="<?php echo e($c2); ?>" stroke-width="1" opacity="0.3"/>
      <?php break; ?>
    <?php case ('arrow'): ?>
      <path d="M<?php echo e($vw * 0.13); ?> <?php echo e($vh * 0.8); ?> L<?php echo e($vw * 0.33); ?> <?php echo e($vh * 0.53); ?> L<?php echo e($vw * 0.5); ?> <?php echo e($vh * 0.66); ?> L<?php echo e($vw * 0.8); ?> <?php echo e($vh * 0.35); ?>" stroke="<?php echo e($c2); ?>" stroke-width="2" fill="none" opacity="0.6"/>
      <?php break; ?>
    <?php default: ?>
      <path d="M0 <?php echo e($vh * 0.75); ?> L<?php echo e($vw * 0.2); ?> <?php echo e($vh * 0.53); ?> L<?php echo e($vw * 0.37); ?> <?php echo e($vh * 0.67); ?> L<?php echo e($vw * 0.6); ?> <?php echo e($vh * 0.35); ?> L<?php echo e($vw); ?> <?php echo e($vh * 0.58); ?>" stroke="<?php echo e($c2); ?>" stroke-width="2" fill="none" opacity="0.55"/>
  <?php endswitch; ?>
</svg>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/partials/art.blade.php ENDPATH**/ ?>
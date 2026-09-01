<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Iklan / Ads','pageSubtitle' => 'Upload dan kelola materi iklan untuk tiap slot di situs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Iklan / Ads'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Upload dan kelola materi iklan untuk tiap slot di situs')]); ?>

  <div class="filter-bar">
    <div style="flex:1; font-size:13px; color:var(--muted);">
      Slot iklan yang tersedia: leaderboard (atas), rectangle (samping), tengah halaman, dan sticky bar mobile.
    </div>
    <a href="<?php echo e(route('admin.ads.create')); ?>" class="btn btn-accent">+ Upload Iklan Baru</a>
  </div>

  <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slotKey => $slotLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="slot-group-title">
      <h3><?php echo e($slotLabel); ?></h3>
      <span><?php echo e(isset($adsBySlot[$slotKey]) ? $adsBySlot[$slotKey]->count() : 0); ?> iklan</span>
    </div>

    <div class="panel">
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Preview</th>
              <th>Judul</th>
              <th>Pengiklan</th>
              <th>Status</th>
              <th>Jadwal</th>
              <th>Klik</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $adsBySlot[$slotKey] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td style="width:90px;">
                  <?php if($ad->image_path): ?>
                    <img src="<?php echo e($ad->image_url); ?>" alt="<?php echo e($ad->title); ?>" style="width:80px; height:50px; object-fit:cover; border-radius:6px; border:1px solid var(--paper-line);">
                  <?php else: ?>
                    <div style="width:80px; height:50px; border-radius:6px; background:var(--paper-alt); display:flex; align-items:center; justify-content:center; font-size:10px; color:var(--muted-2);">Tanpa gambar</div>
                  <?php endif; ?>
                </td>
                <td class="title-cell">
                  <a href="<?php echo e(route('admin.ads.edit', $ad)); ?>"><?php echo e($ad->title); ?></a>
                  <?php if($ad->target_url): ?><div class="sub"><?php echo e(\Illuminate\Support\Str::limit($ad->target_url, 40)); ?></div><?php endif; ?>
                </td>
                <td><?php echo e($ad->advertiser ?: '—'); ?></td>
                <td>
                  <?php if($ad->is_active): ?>
                    <span class="badge badge-green">Aktif</span>
                  <?php else: ?>
                    <span class="badge badge-gray">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td style="font-size:12px; color:var(--muted);">
                  <?php if($ad->starts_at || $ad->ends_at): ?>
                    <?php echo e(optional($ad->starts_at)->translatedFormat('d M Y') ?? 'Kapan saja'); ?> – <?php echo e(optional($ad->ends_at)->translatedFormat('d M Y') ?? 'tanpa batas'); ?>

                  <?php else: ?>
                    Selalu tayang
                  <?php endif; ?>
                </td>
                <td><?php echo e(number_format($ad->clicks)); ?></td>
                <td>
                  <div class="row-actions">
                    <a href="<?php echo e(route('admin.ads.edit', $ad)); ?>" class="btn btn-ghost btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.ads.toggle-active', $ad)); ?>">
                      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn btn-ghost btn-sm"><?php echo e($ad->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?></button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.ads.destroy', $ad)); ?>" data-confirm="Hapus iklan &quot;<?php echo e($ad->title); ?>&quot;?">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="7"><div class="empty-state" style="padding:26px 0;">Belum ada iklan di slot ini.</div></td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/ads/index.blade.php ENDPATH**/ ?>
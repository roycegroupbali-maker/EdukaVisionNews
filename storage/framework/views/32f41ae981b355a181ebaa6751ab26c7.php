<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Akun Admin','pageSubtitle' => 'Konfirmasi pendaftaran akun admin baru, lalu aktifkan atau nonaktifkan akun kapan saja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Akun Admin'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Konfirmasi pendaftaran akun admin baru, lalu aktifkan atau nonaktifkan akun kapan saja')]); ?>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Terdaftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="title-cell">
                <?php echo e($account->name); ?>

                <?php if($account->id === auth()->id()): ?>
                  <div class="sub">Ini akun Anda</div>
                <?php endif; ?>
              </td>
              <td><?php echo e($account->email); ?></td>
              <td>
                <?php if($account->is_active): ?>
                  <span class="badge badge-green">Aktif</span>
                <?php else: ?>
                  <span class="badge badge-gold">Menunggu Aktivasi</span>
                <?php endif; ?>
              </td>
              <td style="font-size:12px; color:var(--muted);"><?php echo e($account->created_at->translatedFormat('d M Y, H:i')); ?></td>
              <td>
                <?php if($account->id === auth()->id()): ?>
                  <span style="font-size:12px; color:var(--muted-2);">—</span>
                <?php else: ?>
                  <div class="row-actions">
                    <form method="POST" action="<?php echo e(route('admin.users.toggle-active', $account)); ?>"
                      data-confirm="<?php echo e($account->is_active
                        ? 'Nonaktifkan akun admin "'.$account->name.'"? Akun ini akan langsung kehilangan akses ke panel admin.'
                        : 'Aktifkan akun admin "'.$account->name.'"? Akun ini akan bisa masuk ke panel admin.'); ?>">
                      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn <?php echo e($account->is_active ? 'btn-ghost' : 'btn-accent'); ?> btn-sm">
                        <?php echo e($account->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                      </button>
                    </form>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5"><div class="empty-state">Belum ada akun admin.</div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/users/index.blade.php ENDPATH**/ ?>
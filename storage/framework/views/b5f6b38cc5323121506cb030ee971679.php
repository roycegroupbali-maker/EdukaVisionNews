<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Jabatan','pageSubtitle' => 'Atur jabatan panel & tentukan sampai mana hak akses tiap jabatan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Jabatan'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Atur jabatan panel & tentukan sampai mana hak akses tiap jabatan')]); ?>

  <div class="filter-bar">
    <div style="flex:1;"></div>
    <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-accent">+ Tambah Jabatan</a>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Jabatan</th>
            <th>Deskripsi</th>
            <th>Hak Akses</th>
            <th>Pengguna</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="title-cell">
                <?php echo e($role->name); ?>

                <?php if($role->is_system): ?>
                  <div class="sub">Jabatan bawaan sistem</div>
                <?php endif; ?>
              </td>
              <td style="max-width:280px; font-size:13px; color:var(--muted);"><?php echo e($role->description ?: '—'); ?></td>
              <td style="font-size:12.5px; color:var(--muted);">
                <?php if($role->slug === \App\Models\Role::SUPER_ADMIN): ?>
                  Semua akses (penuh)
                <?php elseif(empty($role->permissions)): ?>
                  <span style="color:var(--muted-2);">Belum ada akses</span>
                <?php else: ?>
                  <?php echo e(count($role->permissions)); ?> dari <?php echo e(count(\App\Models\Role::permissionCatalog())); ?> hak akses
                <?php endif; ?>
              </td>
              <td><?php echo e($role->users_count); ?> orang</td>
              <td>
                <div class="row-actions">
                  <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="btn btn-ghost btn-sm">
                    <?php echo e($role->slug === \App\Models\Role::SUPER_ADMIN ? 'Lihat' : 'Edit'); ?>

                  </a>
                  <?php if (! ($role->is_system)): ?>
                    <form method="POST" action="<?php echo e(route('admin.roles.destroy', $role)); ?>" data-confirm="Hapus jabatan &quot;<?php echo e($role->name); ?>&quot;? Tindakan ini tidak bisa dibatalkan.">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5"><div class="empty-state"><h3>Belum ada jabatan</h3><p>Tambahkan jabatan custom sesuai struktur redaksi Anda.</p></div></td></tr>
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
<?php endif; ?>
<?php /**PATH D:\web\EdukaVisionNews\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>
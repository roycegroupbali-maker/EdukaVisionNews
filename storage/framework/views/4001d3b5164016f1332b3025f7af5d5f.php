<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Kategori','pageSubtitle' => 'Kelola rubrik/kategori tempat berita dikelompokkan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kategori'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kelola rubrik/kategori tempat berita dikelompokkan')]); ?>

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head"><h2>Daftar Kategori</h2></div>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Jumlah Berita</th>
                <th>Urutan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                <form id="cat-update-<?php echo e($cat->id); ?>" method="POST" action="<?php echo e(route('admin.categories.update', $cat)); ?>"></form>
                <form id="cat-delete-<?php echo e($cat->id); ?>" method="POST" action="<?php echo e(route('admin.categories.destroy', $cat)); ?>" data-confirm="Hapus kategori &quot;<?php echo e($cat->name); ?>&quot;?"></form>
                <tr>
                  <td>
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" form="cat-update-<?php echo e($cat->id); ?>">
                    <input type="hidden" name="_method" value="PUT" form="cat-update-<?php echo e($cat->id); ?>">
                    <input type="text" name="name" value="<?php echo e($cat->name); ?>" form="cat-update-<?php echo e($cat->id); ?>" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:150px;">
                  </td>
                  <td><input type="text" name="slug" value="<?php echo e($cat->slug); ?>" form="cat-update-<?php echo e($cat->id); ?>" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:130px;"></td>
                  <td><?php echo e($cat->articles_count); ?></td>
                  <td><input type="number" name="sort_order" value="<?php echo e($cat->sort_order); ?>" form="cat-update-<?php echo e($cat->id); ?>" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:64px;"></td>
                  <td>
                    <div class="row-actions">
                      <button type="submit" form="cat-update-<?php echo e($cat->id); ?>" class="btn btn-ghost btn-sm">Simpan</button>
                      <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" form="cat-delete-<?php echo e($cat->id); ?>">
                      <input type="hidden" name="_method" value="DELETE" form="cat-delete-<?php echo e($cat->id); ?>">
                      <button type="submit" form="cat-delete-<?php echo e($cat->id); ?>" class="btn btn-danger btn-sm" <?php if($cat->articles_count > 0): echo 'disabled'; endif; ?> title="<?php echo e($cat->articles_count > 0 ? 'Pindahkan/hapus dulu beritanya' : 'Hapus kategori'); ?>">Hapus</button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5"><div class="empty-state"><h3>Belum ada kategori</h3></div></td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Tambah Kategori Baru</h3>
        <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
          <?php echo csrf_field(); ?>
          <div class="field">
            <label for="newCatName">Nama Kategori</label>
            <input type="text" id="newCatName" name="name" required maxlength="100" placeholder="mis. Kesehatan">
          </div>
          <div class="field">
            <label for="newCatSlug">Slug <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="text" id="newCatSlug" name="slug" maxlength="100" placeholder="kesehatan">
          </div>
          <div class="field">
            <label for="newCatSort">Urutan Tampil</label>
            <input type="number" id="newCatSort" name="sort_order" min="0" placeholder="11">
          </div>
          <button type="submit" class="btn btn-accent btn-block">+ Tambah Kategori</button>
        </form>
      </div>
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
<?php /**PATH D:\web\EdukaVisionNews\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>
<?php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store');
    $isSuperAdmin = $role->slug === \App\Models\Role::SUPER_ADMIN;
    $selected = old('permissions', $role->permissions ?? []);

    // Kelompokkan katalog permission per area supaya form lebih mudah dibaca.
    $groups = [
        'Berita & Alur Verifikasi' => ['articles.create', 'articles.view_all', 'articles.publish', 'articles.delete'],
        'Konten Situs' => ['categories.manage', 'running_texts.manage', 'news_submissions.manage', 'ads.manage'],
        'Analitik' => ['stats.view'],
        'Panel Admin' => ['users.manage', 'roles.manage'],
    ];
?>

<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => $isEdit ? 'Edit Jabatan' : 'Tambah Jabatan','pageSubtitle' => 'Tentukan nama jabatan & hak akses yang dimilikinya di panel admin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isEdit ? 'Edit Jabatan' : 'Tambah Jabatan'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Tentukan nama jabatan & hak akses yang dimilikinya di panel admin')]); ?>

  <form method="POST" action="<?php echo e($action); ?>">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Hak Akses</h3>

          <?php if($isSuperAdmin): ?>
            <p style="font-size:13px; color:var(--muted); margin-bottom:14px;">
              Super Admin selalu memiliki <strong>seluruh hak akses</strong> secara otomatis dan tidak bisa dibatasi lewat form ini, supaya panel selalu punya minimal satu akun berkuasa penuh.
            </p>
          <?php endif; ?>

          <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $keys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom:18px;">
              <div style="font-weight:600; font-size:13px; color:var(--ink-2); margin-bottom:8px;"><?php echo e($groupLabel); ?></div>
              <div style="display:flex; flex-direction:column; gap:8px;">
                <?php $__currentLoopData = $keys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <label class="field checkbox-field" style="align-items:flex-start; margin:0;">
                    <input type="checkbox" name="permissions[]" value="<?php echo e($key); ?>"
                      <?php if($isSuperAdmin || in_array($key, $selected, true)): echo 'checked'; endif; ?>
                      <?php if($isSuperAdmin): echo 'disabled'; endif; ?>>
                    <span style="margin:0;">
                      <strong style="display:block; font-size:13.5px;"><?php echo e($key); ?></strong>
                      <span style="font-size:12.5px; color:var(--muted);"><?php echo e(\App\Models\Role::permissionCatalog()[$key]); ?></span>
                    </span>
                  </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php $__errorArgs = ['permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div class="sticky-side">
        <div class="form-card">
          <h3>Detail Jabatan</h3>

          <div class="field">
            <label for="nameInput">Nama Jabatan</label>
            <input type="text" id="nameInput" name="name" value="<?php echo e(old('name', $role->name)); ?>" required maxlength="100"
              placeholder="mis. Redaktur Pelaksana" <?php if($role->is_system): echo 'disabled'; endif; ?>>
            <?php if($role->is_system): ?>
              <div class="field-hint">Nama jabatan bawaan sistem tidak bisa diubah.</div>
              <input type="hidden" name="name" value="<?php echo e($role->name); ?>">
            <?php endif; ?>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="descriptionInput">Deskripsi <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <textarea id="descriptionInput" name="description" maxlength="255" style="min-height:80px;"
              placeholder="Jelaskan tanggung jawab jabatan ini…"><?php echo e(old('description', $role->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>

        <div class="form-actions">
          <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-accent"><?php echo e($isEdit ? 'Simpan Perubahan' : 'Simpan Jabatan'); ?></button>
        </div>
      </div>
    </div>
  </form>

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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/roles/form.blade.php ENDPATH**/ ?>
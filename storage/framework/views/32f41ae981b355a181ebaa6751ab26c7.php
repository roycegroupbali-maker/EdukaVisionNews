<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Akun Admin','pageSubtitle' => 'Konfirmasi pendaftaran akun baru, atur jabatan, lalu aktifkan atau nonaktifkan akun kapan saja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Akun Admin'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Konfirmasi pendaftaran akun baru, atur jabatan, lalu aktifkan atau nonaktifkan akun kapan saja')]); ?>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
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
              <td>
                <?php if(auth()->user()->isSuperAdmin()): ?>
                  <a href="<?php echo e(route('admin.users.access', $account)); ?>"><?php echo e($account->email); ?></a>
                <?php else: ?>
                  <?php echo e($account->email); ?>

                <?php endif; ?>
                <?php if($account->hasCustomAccess()): ?>
                  <div class="sub" style="color:var(--gold-deep);">Akses khusus</div>
                <?php endif; ?>
              </td>
              <td>
                <?php if($account->id === auth()->id() && ! auth()->user()->isSuperAdmin()): ?>
                  <span class="badge badge-gray"><?php echo e($account->role_name); ?></span>
                <?php else: ?>
                  <form method="POST" action="<?php echo e(route('admin.users.update-role', $account)); ?>" style="display:inline-block;">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <select name="role_id" onchange="this.form.submit()" style="min-width:160px;">
                      <option value="">— Tanpa jabatan —</option>
                      <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->id); ?>" <?php if($account->role_id === $role->id): echo 'selected'; endif; ?>><?php echo e($role->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </form>
                <?php endif; ?>
              </td>
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
                        ? 'Nonaktifkan akun \"'.$account->name.'\"? Akun ini akan langsung kehilangan akses ke panel admin.'
                        : 'Aktifkan akun \"'.$account->name.'\"? Akun ini akan bisa masuk ke panel admin.'); ?>">
                      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn <?php echo e($account->is_active ? 'btn-ghost' : 'btn-accent'); ?> btn-sm">
                        <?php echo e($account->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                      </button>
                    </form>

                    <?php if(! $account->is_active && ! $account->isSuperAdmin()): ?>
                      <form method="POST" action="<?php echo e(route('admin.users.destroy', $account)); ?>"
                        data-confirm="Hapus permanen akun &quot;<?php echo e($account->name); ?>&quot; (<?php echo e($account->email); ?>)? Tindakan ini tidak bisa dibatalkan.">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state">Belum ada akun.</div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <p style="font-size:12.5px; color:var(--muted-2); margin-top:14px;">
    Jabatan menentukan hak akses tiap akun di panel — kelola daftar jabatan &amp; hak aksesnya di menu <a href="<?php echo e(route('admin.roles.index')); ?>">Jabatan</a>.
  </p>

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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/users/index.blade.php ENDPATH**/ ?>
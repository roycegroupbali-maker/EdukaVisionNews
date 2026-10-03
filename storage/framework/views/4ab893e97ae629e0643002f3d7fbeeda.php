<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Pengaturan Akun','pageSubtitle' => 'Kelola nama, email, dan kata sandi akun admin kamu']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Pengaturan Akun'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kelola nama, email, dan kata sandi akun admin kamu')]); ?>

  <div class="form-grid">
    <div>
      <div class="form-card">
        <h3>Informasi Akun</h3>

        <form method="POST" action="<?php echo e(route('admin.account.update')); ?>">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          <div class="field">
            <label for="accName">Nama</label>
            <input type="text" id="accName" name="name" value="<?php echo e(old('name', $user->name)); ?>" required maxlength="100">
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
            <label for="accEmail">Email</label>
            <input type="email" id="accEmail" name="email" value="<?php echo e(old('email', $user->email)); ?>" required maxlength="150">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="accPassword">Kata Sandi Baru <span style="font-weight:400; color:var(--muted-2);">(kosongkan kalau tidak ingin mengganti)</span></label>
            <input type="password" id="accPassword" name="password" placeholder="••••••••" autocomplete="new-password">
            <div class="field-hint">Minimal 8 karakter.</div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="accPasswordConfirm">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="accPasswordConfirm" name="password_confirmation" placeholder="••••••••" autocomplete="new-password">
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-accent">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Verifikasi Email</h3>
        <?php if($user->email_verified_at): ?>
          <p style="font-size:13px; color:var(--muted); line-height:1.6;">
            ✓ Email <strong><?php echo e($user->email); ?></strong> sudah terverifikasi
            (<?php echo e($user->email_verified_at->translatedFormat('d M Y')); ?>).
          </p>
        <?php else: ?>
          <p style="font-size:13px; color:var(--muted); line-height:1.6;">
            Email <strong><?php echo e($user->email); ?></strong> belum diverifikasi. Verifikasi bersifat
            opsional dan tidak memengaruhi login. Kami akan mengirim tautan ke email ini
            hanya saat kamu menekan tombol di bawah.
          </p>
          <form method="POST" action="<?php echo e(route('admin.account.verification.send')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-accent">Kirim email verifikasi</button>
          </form>
        <?php endif; ?>
      </div>

      <div class="form-card">
        <h3>Keamanan</h3>
        <p style="font-size:13px; color:var(--muted); line-height:1.6;">
          Halaman ini dikunci dengan konfirmasi kata sandi. Setelah beberapa waktu tidak
          digunakan, kamu akan diminta memasukkan kata sandi lagi sebelum bisa mengubah
          data akun.
        </p>
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/account/edit.blade.php ENDPATH**/ ?>
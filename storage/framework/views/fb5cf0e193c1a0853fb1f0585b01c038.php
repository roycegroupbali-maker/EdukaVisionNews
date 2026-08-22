<?php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.ads.update', $ad) : route('admin.ads.store');
?>

<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => $isEdit ? 'Edit Iklan' : 'Upload Iklan Baru','pageSubtitle' => 'Materi iklan akan tayang otomatis di slot yang dipilih']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isEdit ? 'Edit Iklan' : 'Upload Iklan Baru'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Materi iklan akan tayang otomatis di slot yang dipilih')]); ?>

  <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Materi Iklan</h3>

          <div class="field">
            <label for="adImageInput">Gambar Iklan</label>
            <?php if($isEdit && $ad->image_path): ?>
              <img id="adImagePreview" src="<?php echo e($ad->image_url); ?>" alt="<?php echo e($ad->title); ?>" class="ad-image-preview">
            <?php else: ?>
              <img id="adImagePreview" src="" alt="" class="ad-image-preview" style="display:none;">
            <?php endif; ?>
            <input type="file" id="adImageInput" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <div class="field-hint">Format JPG/PNG/WEBP/GIF, maksimal 4MB. <?php echo e($isEdit ? 'Kosongkan jika tidak ingin mengganti gambar.' : ''); ?> Rasio disarankan mengikuti ukuran slot yang dipilih.</div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field">
            <label for="adTitleInput">Judul / Nama Iklan</label>
            <input type="text" id="adTitleInput" name="title" value="<?php echo e(old('title', $ad->title)); ?>" required maxlength="150" placeholder="mis. Promo Akhir Tahun Bank ABC">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="form-row">
            <div class="field">
              <label for="adAdvertiser">Nama Pengiklan</label>
              <input type="text" id="adAdvertiser" name="advertiser" value="<?php echo e(old('advertiser', $ad->advertiser)); ?>" maxlength="150" placeholder="mis. Bank ABC">
            </div>
            <div class="field">
              <label for="adCta">Teks Tombol (CTA)</label>
              <input type="text" id="adCta" name="cta_text" value="<?php echo e(old('cta_text', $ad->cta_text)); ?>" maxlength="50" placeholder="Pelajari Selengkapnya">
            </div>
          </div>

          <div class="field">
            <label for="adTargetUrl">Tautan Tujuan</label>
            <input type="url" id="adTargetUrl" name="target_url" value="<?php echo e(old('target_url', $ad->target_url)); ?>" maxlength="255" placeholder="https://pengiklan.com/promo">
            <?php $__errorArgs = ['target_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
      </div>

      <div class="sticky-side">
        <div class="form-card">
          <h3>Penempatan</h3>

          <div class="field">
            <label for="adSlot">Slot Iklan</label>
            <select id="adSlot" name="slot" required>
              <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(old('slot', $ad->slot) === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['slot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="field checkbox-field">
            <input type="checkbox" id="adIsActive" name="is_active" value="1" <?php if(old('is_active', $ad->exists ? $ad->is_active : true)): echo 'checked'; endif; ?>>
            <label for="adIsActive" style="margin:0;">Aktifkan iklan ini</label>
          </div>

          <div class="field">
            <label for="adSortOrder">Prioritas Urutan</label>
            <input type="number" id="adSortOrder" name="sort_order" min="0" value="<?php echo e(old('sort_order', $ad->sort_order)); ?>">
            <div class="field-hint">Angka lebih kecil tampil lebih dulu jika ada beberapa iklan aktif di slot yang sama.</div>
          </div>
        </div>

        <div class="form-card">
          <h3>Jadwal Tayang <span style="font-weight:400; font-size:12px; color:var(--muted-2);">(opsional)</span></h3>
          <div class="field">
            <label for="adStartsAt">Mulai Tayang</label>
            <input type="datetime-local" id="adStartsAt" name="starts_at" value="<?php echo e(old('starts_at', optional($ad->starts_at)->format('Y-m-d\TH:i'))); ?>">
          </div>
          <div class="field">
            <label for="adEndsAt">Berakhir</label>
            <input type="datetime-local" id="adEndsAt" name="ends_at" value="<?php echo e(old('ends_at', optional($ad->ends_at)->format('Y-m-d\TH:i'))); ?>">
            <?php $__errorArgs = ['ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="field-hint">Kosongkan kedua kolom untuk tayang terus-menerus selama status Aktif.</div>
        </div>

        <div class="form-actions">
          <a href="<?php echo e(route('admin.ads.index')); ?>" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-accent"><?php echo e($isEdit ? 'Simpan Perubahan' : 'Upload Iklan'); ?></button>
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/ads/form.blade.php ENDPATH**/ ?>
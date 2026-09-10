<?php
    $badgeClass = match($submission->status) {
        'approved' => 'badge-green',
        'rejected' => 'badge-red',
        'reviewed' => 'badge-gold',
        default => 'badge-gray',
    };
?>

<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Detail Pengajuan Berita','pageSubtitle' => $submission->title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Detail Pengajuan Berita'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($submission->title)]); ?>

  <div style="margin-bottom:18px;">
    <a href="<?php echo e(route('admin.news-submissions.index')); ?>" class="btn btn-ghost btn-sm">&larr; Kembali ke Daftar Pengajuan</a>
  </div>

  <div class="form-grid">
    <div>
      <div class="form-card">
        <h3><?php echo e($submission->title); ?></h3>

        <div style="display:flex; gap:10px; align-items:center; margin:4px 0 20px;">
          <span class="sub" style="font-size:12.5px; font-weight:600;">Tiket #<?php echo e(str_pad($submission->id, 5, '0', STR_PAD_LEFT)); ?></span>
          <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($submission->status_label); ?></span>
          <span class="sub" style="font-size:12.5px; color:var(--muted-2);">Dikirim <?php echo e($submission->created_at->translatedFormat('d F Y, H:i')); ?></span>
        </div>

        <?php if($submission->image_url): ?>
          <div class="field">
            <label>Lampiran Foto</label>
            <img src="<?php echo e($submission->image_url); ?>" alt="Lampiran dari <?php echo e($submission->name); ?>" style="max-width:100%; border-radius:8px; border:1px solid var(--paper-line);">
          </div>
        <?php endif; ?>

        <div class="field">
          <label>Isi / Ringkasan Berita</label>
          <p style="white-space:pre-line; line-height:1.7; font-size:14.5px;"><?php echo e($submission->content); ?></p>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Pengirim</h3>
        <div class="field">
          <label>Nama</label>
          <p><?php echo e($submission->name); ?></p>
        </div>
        <div class="field">
          <label>Email</label>
          <p><a href="mailto:<?php echo e($submission->email); ?>"><?php echo e($submission->email); ?></a></p>
        </div>
        <div class="field">
          <label>Nomor Telepon</label>
          <p><?php if($submission->phone): ?><a href="tel:<?php echo e($submission->phone); ?>"><?php echo e($submission->phone); ?></a><?php else: ?> <span style="color:var(--muted-2);">—</span><?php endif; ?></p>
        </div>
      </div>

      <div class="form-card">
        <h3>Tinjau Pengajuan</h3>
        <form method="POST" action="<?php echo e(route('admin.news-submissions.update-status', $submission)); ?>">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PATCH'); ?>

          <div class="field">
            <label for="statusSelect">Status</label>
            <select id="statusSelect" name="status" required>
              <?php $__currentLoopData = \App\Models\NewsSubmission::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(old('status', $submission->status) === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <div class="field">
            <label for="adminNote">Catatan Internal <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <textarea id="adminNote" name="admin_note" style="min-height:100px;" placeholder="Catatan untuk tim redaksi, mis. alasan penolakan atau tindak lanjut…"><?php echo e(old('admin_note', $submission->admin_note)); ?></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-accent">Simpan Status</button>
          </div>
        </form>
      </div>

      <div class="form-card">
        <form method="POST" action="<?php echo e(route('admin.news-submissions.destroy', $submission)); ?>" data-confirm="Hapus pengajuan berita ini? Tindakan ini tidak bisa dibatalkan.">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button type="submit" class="btn btn-danger btn-block">Hapus Pengajuan Ini</button>
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
<?php endif; ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/news-submissions/show.blade.php ENDPATH**/ ?>
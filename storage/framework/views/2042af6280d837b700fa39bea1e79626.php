<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Pengajuan Berita','pageSubtitle' => 'Usulan berita &amp; laporan yang dikirim pembaca lewat formulir Ajukan Berita']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Pengajuan Berita'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Usulan berita &amp; laporan yang dikirim pembaca lewat formulir Ajukan Berita')]); ?>

  <div class="filter-bar">
    <form method="GET" action="<?php echo e(route('admin.news-submissions.index')); ?>" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <?php $__currentLoopData = \App\Models\NewsSubmission::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($key); ?>" <?php if(request('status') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul, nama, atau email…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      <?php if(request()->anyFilled(['status','q'])): ?>
        <a href="<?php echo e(route('admin.news-submissions.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>
    <?php if($pendingCount > 0): ?>
      <span class="badge badge-red"><?php echo e($pendingCount); ?> menunggu ditinjau</span>
    <?php endif; ?>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tiket</th>
            <th>Judul Usulan</th>
            <th>Pengirim</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="sub">#<?php echo e(str_pad($submission->id, 5, '0', STR_PAD_LEFT)); ?></td>
              <td class="title-cell">
                <a href="<?php echo e(route('admin.news-submissions.show', $submission)); ?>"><?php echo e($submission->title); ?></a>
                <?php if($submission->image_path): ?><div class="sub">📎 dengan lampiran foto</div><?php endif; ?>
              </td>
              <td>
                <?php echo e($submission->name); ?>

                <div class="sub"><?php echo e($submission->email); ?></div>
                <?php if($submission->phone): ?><div class="sub"><?php echo e($submission->phone); ?></div><?php endif; ?>
              </td>
              <td>
                <?php
                  $badgeClass = match($submission->status) {
                    'approved' => 'badge-green',
                    'rejected' => 'badge-red',
                    'reviewed' => 'badge-gold',
                    default => 'badge-gray',
                  };
                ?>
                <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($submission->status_label); ?></span>
              </td>
              <td><?php echo e($submission->created_at->translatedFormat('d M Y, H:i')); ?></td>
              <td>
                <div class="row-actions">
                  <a href="<?php echo e(route('admin.news-submissions.show', $submission)); ?>" class="btn btn-ghost btn-sm">Lihat</a>
                  <form method="POST" action="<?php echo e(route('admin.news-submissions.destroy', $submission)); ?>" data-confirm="Hapus pengajuan berita &quot;<?php echo e($submission->title); ?>&quot;? Tindakan ini tidak bisa dibatalkan.">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><h3>Belum ada pengajuan berita</h3><p>Usulan berita yang dikirim pembaca lewat formulir "Ajukan Berita" akan muncul di sini.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap"><?php echo e($submissions->links()); ?></div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?><?php /**PATH D:\web\EdukaVisionNews\resources\views/admin/news-submissions/index.blade.php ENDPATH**/ ?>
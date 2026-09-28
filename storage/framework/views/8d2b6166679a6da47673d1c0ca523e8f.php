<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Tempat Sampah Berita','pageSubtitle' => 'Cadangan berita yang dihapus — hanya terlihat oleh Super Admin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Tempat Sampah Berita'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Cadangan berita yang dihapus — hanya terlihat oleh Super Admin')]); ?>

  <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
    Berita di sini <strong>sudah tidak tampil di web</strong> dan tidak terlihat oleh editor/wartawan.
    Pulihkan untuk menayangkannya kembali dengan status semula, atau hapus permanen (tidak bisa dibatalkan).
  </div>

  <div class="filter-bar">
    <form method="GET" action="<?php echo e(route('admin.trash.index')); ?>" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul berita terhapus…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      <?php if(request()->filled('q')): ?>
        <a href="<?php echo e(route('admin.trash.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div id="bulkBar" style="display:none; align-items:center; gap:12px; flex-wrap:wrap; padding:10px 14px; margin-bottom:12px; border-radius:8px; background:rgba(27,75,67,0.08); border:1px solid rgba(27,75,67,0.25);">
    <span><strong id="bulkCount">0</strong> berita dipilih</span>
    <button type="button" id="bulkRestoreBtn" class="btn btn-accent btn-sm">Pulihkan Terpilih</button>
    <button type="button" id="bulkForceBtn" class="btn btn-danger btn-sm">Hapus Permanen</button>
    <button type="button" id="bulkCancelBtn" class="btn btn-ghost btn-sm">Batal</button>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width:36px;"><input type="checkbox" id="checkAll" title="Pilih semua di halaman ini"></th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status Terakhir</th>
            <th>Dihapus</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><input type="checkbox" class="row-check" value="<?php echo e($article->id); ?>"></td>
              <td class="title-cell">
                <?php echo e($article->title); ?>

                <div class="sub">oleh <?php echo e($article->authorUser->name ?? $article->author); ?></div>
              </td>
              <td><?php echo e($article->category->name ?? '—'); ?></td>
              <td><span class="badge <?php echo e($article->status_badge_class); ?>"><?php echo e($article->status_label); ?></span></td>
              <td>
                <?php echo e($article->deleted_at->translatedFormat('d M Y H:i')); ?>

                <div class="sub">oleh <?php echo e($article->deletedByUser->name ?? '—'); ?></div>
              </td>
              <td>
                <div class="row-actions">
                  <form method="POST" action="<?php echo e(route('admin.trash.restore')); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="ids[]" value="<?php echo e($article->id); ?>">
                    <button type="submit" class="btn btn-accent btn-sm">Pulihkan</button>
                  </form>
                  <form method="POST" action="<?php echo e(route('admin.trash.force-delete')); ?>" data-confirm="Hapus PERMANEN &quot;<?php echo e($article->title); ?>&quot;? Tidak bisa dipulihkan lagi.">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <input type="hidden" name="ids[]" value="<?php echo e($article->id); ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus Permanen</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><h3>Tempat sampah kosong</h3><p>Berita yang dihapus akan muncul di sini.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap"><?php echo e($articles->links()); ?></div>

  <form method="POST" id="bulkRestoreForm" action="<?php echo e(route('admin.trash.restore')); ?>" style="display:none;"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?></form>
  <form method="POST" id="bulkForceForm" action="<?php echo e(route('admin.trash.force-delete')); ?>" style="display:none;"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?></form>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var checkAll = document.getElementById('checkAll');
      var bar = document.getElementById('bulkBar');
      var countEl = document.getElementById('bulkCount');
      var rows = Array.prototype.slice.call(document.querySelectorAll('.row-check'));

      function selected() { return rows.filter(function (c) { return c.checked; }); }

      function refresh() {
        var n = selected().length;
        countEl.textContent = n;
        bar.style.display = n > 0 ? 'flex' : 'none';
        checkAll.checked = n > 0 && n === rows.length;
        checkAll.indeterminate = n > 0 && n < rows.length;
      }

      function submitWith(formId, confirmMsg) {
        var sel = selected();
        if (!sel.length) return;
        if (confirmMsg && !window.confirm(confirmMsg.replace('{n}', sel.length))) return;
        var form = document.getElementById(formId);
        sel.forEach(function (c) {
          var input = document.createElement('input');
          input.type = 'hidden'; input.name = 'ids[]'; input.value = c.value;
          form.appendChild(input);
        });
        form.submit();
      }

      checkAll.addEventListener('change', function () {
        rows.forEach(function (c) { c.checked = checkAll.checked; });
        refresh();
      });
      rows.forEach(function (c) { c.addEventListener('change', refresh); });

      document.getElementById('bulkCancelBtn').addEventListener('click', function () {
        rows.forEach(function (c) { c.checked = false; });
        refresh();
      });
      document.getElementById('bulkRestoreBtn').addEventListener('click', function () {
        submitWith('bulkRestoreForm', 'Pulihkan {n} berita terpilih?');
      });
      document.getElementById('bulkForceBtn').addEventListener('click', function () {
        submitWith('bulkForceForm', 'Hapus PERMANEN {n} berita terpilih? Tidak bisa dipulihkan lagi.');
      });
    });
  </script>

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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/trash/index.blade.php ENDPATH**/ ?>
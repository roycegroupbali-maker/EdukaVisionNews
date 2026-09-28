<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Komentar','pageSubtitle' => 'Moderasi komentar pembaca di seluruh berita']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Komentar'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Moderasi komentar pembaca di seluruh berita')]); ?>

  <?php if($pendingCount > 0): ?>
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Ada <strong><?php echo e($pendingCount); ?></strong> komentar menunggu moderasi.
      <a href="<?php echo e(route('admin.comments.index', ['status' => 'pending'])); ?>" style="font-weight:600;">Lihat &rarr;</a>
    </div>
  <?php endif; ?>

  <div class="filter-bar">
    <form method="GET" action="<?php echo e(route('admin.comments.index')); ?>" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <?php $__currentLoopData = \App\Models\Comment::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($val); ?>" <?php if(request('status') === $val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama / isi komentar…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      <?php if(request()->anyFilled(['status', 'q'])): ?>
        <a href="<?php echo e(route('admin.comments.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Berita</th>
            <th>Nama</th>
            <th>Komentar</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="max-width:220px;">
                <?php if($comment->article): ?>
                  <a href="<?php echo e(route('article.show', $comment->article->slug)); ?>" target="_blank" rel="noopener"><?php echo e(\Illuminate\Support\Str::limit($comment->article->title, 45)); ?></a>
                <?php else: ?>
                  <span style="color:var(--muted-2);">(berita dihapus)</span>
                <?php endif; ?>
              </td>
              <td><?php echo e($comment->name); ?></td>
              <td style="max-width:340px; white-space:pre-wrap;"><?php echo e(\Illuminate\Support\Str::limit($comment->body, 220)); ?></td>
              <td style="white-space:nowrap;"><?php echo e($comment->created_at->translatedFormat('d M Y, H:i')); ?></td>
              <td><span class="badge <?php echo e($comment->status_badge_class); ?>"><?php echo e($comment->status_label); ?></span></td>
              <td>
                <div class="row-actions">
                  <?php if($comment->status !== \App\Models\Comment::STATUS_APPROVED): ?>
                    <form method="POST" action="<?php echo e(route('admin.comments.approve', $comment)); ?>">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn btn-ghost btn-sm">Setujui</button>
                    </form>
                  <?php endif; ?>
                  <?php if($comment->status !== \App\Models\Comment::STATUS_HIDDEN): ?>
                    <form method="POST" action="<?php echo e(route('admin.comments.hide', $comment)); ?>">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn btn-ghost btn-sm">Sembunyikan</button>
                    </form>
                  <?php endif; ?>
                  <form method="POST" action="<?php echo e(route('admin.comments.destroy', $comment)); ?>" data-confirm="Hapus komentar ini secara permanen?">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6"><div class="empty-state"><h3>Belum ada komentar</h3><p>Komentar dari pembaca yang mengisi form di halaman berita akan muncul di sini untuk dimoderasi.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap"><?php echo e($comments->links()); ?></div>
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/comments/index.blade.php ENDPATH**/ ?>
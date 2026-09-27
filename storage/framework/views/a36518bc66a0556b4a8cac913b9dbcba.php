<?php
    $me = auth()->user();
    $canPublish = $me->hasPermission('articles.publish');
?>

<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Berita','pageSubtitle' => $canPublish ? 'Kelola semua berita, tinjau pengajuan wartawan' : 'Berita yang Anda tulis & ajukan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Berita'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($canPublish ? 'Kelola semua berita, tinjau pengajuan wartawan' : 'Berita yang Anda tulis & ajukan')]); ?>

  <?php if($canPublish && $pendingCount > 0): ?>
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Ada <strong><?php echo e($pendingCount); ?></strong> berita menunggu tinjauan Anda.
      <a href="<?php echo e(route('admin.articles.index', ['status' => 'pending'])); ?>" style="font-weight:600;">Lihat &rarr;</a>
    </div>
  <?php endif; ?>

  <div class="filter-bar">
    <form method="GET" action="<?php echo e(route('admin.articles.index')); ?>" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="category" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($c->slug); ?>" <?php if(request('category') === $c->slug): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <?php $__currentLoopData = \App\Models\Article::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($val); ?>" <?php if(request('status') === $val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul berita…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      <?php if(request()->anyFilled(['category','status','q'])): ?>
        <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>
    <?php if($me->hasPermission('articles.create')): ?>
      <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-accent">+ Tulis Berita</a>
    <?php endif; ?>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th></th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Views</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td style="width:52px;">
                <div style="width:48px; height:36px; border-radius:4px; overflow:hidden; background:var(--paper-alt);">
                  <?php echo $__env->make('partials.art', ['article' => $article, 'viewbox' => '0 0 48 36'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
              </td>
              <td class="title-cell">
                <?php if($canPublish || $article->author_id === $me->id): ?>
                  <a href="<?php echo e(route('admin.articles.edit', $article)); ?>"><?php echo e($article->title); ?></a>
                <?php else: ?>
                  <?php echo e($article->title); ?>

                <?php endif; ?>
                <div class="sub">
                  oleh <?php echo e($article->authorUser->name ?? $article->author); ?>

                  <?php if($article->status === \App\Models\Article::STATUS_REVISION && $article->review_note): ?>
                    · <span style="color:var(--pulse-deep);">Catatan: <?php echo e(\Illuminate\Support\Str::limit($article->review_note, 60)); ?></span>
                  <?php endif; ?>
                </div>
              </td>
              <td><?php echo e($article->category->name ?? '—'); ?></td>
              <td>
                <span class="badge <?php echo e($article->status_badge_class); ?>"><?php echo e($article->status_label); ?></span>
                <?php if($article->is_featured): ?>
                  <span class="badge badge-gold">Headline</span>
                <?php endif; ?>
              </td>
              <td><?php echo e(number_format($article->views)); ?></td>
              <td><?php echo e($article->created_at->translatedFormat('d M Y')); ?></td>
              <td>
                <div class="row-actions">
                  <?php if($canPublish && in_array($article->status, [\App\Models\Article::STATUS_PENDING, \App\Models\Article::STATUS_REVISION], true)): ?>
                    <form method="POST" action="<?php echo e(route('admin.articles.approve', $article)); ?>">
                      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn btn-accent btn-sm">ACC &amp; Tayangkan</button>
                    </form>
                    <button type="button" class="btn btn-danger btn-sm js-reject-btn" data-action="<?php echo e(route('admin.articles.reject', $article)); ?>">Tolak / Revisi</button>
                  <?php endif; ?>

                  <?php if($canPublish || $article->author_id === $me->id): ?>
                    <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="btn btn-ghost btn-sm">Edit</a>
                  <?php endif; ?>

                  <?php if($canPublish): ?>
                    <form method="POST" action="<?php echo e(route('admin.articles.toggle-featured', $article)); ?>">
                      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                      <button type="submit" class="btn btn-ghost btn-sm"><?php echo e($article->is_featured ? 'Lepas Headline' : 'Jadikan Headline'); ?></button>
                    </form>
                  <?php endif; ?>

                  <?php if($me->hasPermission('articles.delete') || ($article->author_id === $me->id && in_array($article->status, [\App\Models\Article::STATUS_DRAFT, \App\Models\Article::STATUS_REVISION], true))): ?>
                    <form method="POST" action="<?php echo e(route('admin.articles.destroy', $article)); ?>" data-confirm="Hapus berita &quot;<?php echo e($article->title); ?>&quot;? Tindakan ini tidak bisa dibatalkan.">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7"><div class="empty-state"><h3>Belum ada berita</h3><p>Mulai tulis berita pertama sesuai kategori yang diinginkan.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap"><?php echo e($articles->links()); ?></div>

  <!-- Form tersembunyi untuk aksi "Tolak / Revisi" — catatan diminta lewat prompt() lalu dikirim ke sini -->
  <form method="POST" id="rejectForm" style="display:none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>
    <input type="hidden" name="review_note" id="rejectNoteInput">
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.js-reject-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var note = window.prompt('Catatan revisi untuk wartawan (wajib diisi, jelaskan apa yang perlu diperbaiki):');
          if (note === null) return; // dibatalkan
          note = note.trim();
          if (!note) {
            window.alert('Catatan revisi wajib diisi.');
            return;
          }
          var form = document.getElementById('rejectForm');
          form.action = btn.getAttribute('data-action');
          document.getElementById('rejectNoteInput').value = note;
          form.submit();
        });
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/articles/index.blade.php ENDPATH**/ ?>
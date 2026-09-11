<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Berita','pageSubtitle' => 'Kelola semua berita, filter berdasarkan kategori']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Berita'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Kelola semua berita, filter berdasarkan kategori')]); ?>

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
        <option value="published" <?php if(request('status') === 'published'): echo 'selected'; endif; ?>>Tayang</option>
        <option value="draft" <?php if(request('status') === 'draft'): echo 'selected'; endif; ?>>Draf</option>
      </select>
      <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul berita…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      <?php if(request()->anyFilled(['category','status','q'])): ?>
        <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>
    <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-accent">+ Tulis Berita</a>
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
            <th>Share</th>
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
                <a href="<?php echo e(route('admin.articles.edit', $article)); ?>"><?php echo e($article->title); ?></a>
                <div class="sub">oleh <?php echo e($article->author); ?></div>
              </td>
              <td><?php echo e($article->category->name ?? '—'); ?></td>
              <td>
                <?php if($article->published_at && $article->published_at->lte(now())): ?>
                  <span class="badge badge-green">Tayang</span>
                <?php else: ?>
                  <span class="badge badge-gray">Draf</span>
                <?php endif; ?>
                <?php if($article->is_featured): ?>
                  <span class="badge badge-gold">Headline</span>
                <?php endif; ?>
              </td>
              <td><?php echo e(number_format($article->views)); ?></td>
              <td><?php echo e(number_format($article->shares)); ?></td>
              <td><?php echo e($article->created_at->translatedFormat('d M Y')); ?></td>
              <td>
                <div class="row-actions">
                  <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="btn btn-ghost btn-sm">Edit</a>
                  <form method="POST" action="<?php echo e(route('admin.articles.toggle-featured', $article)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-ghost btn-sm"><?php echo e($article->is_featured ? 'Lepas Headline' : 'Jadikan Headline'); ?></button>
                  </form>
                  <form method="POST" action="<?php echo e(route('admin.articles.destroy', $article)); ?>" data-confirm="Hapus berita &quot;<?php echo e($article->title); ?>&quot;? Tindakan ini tidak bisa dibatalkan.">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8"><div class="empty-state"><h3>Belum ada berita</h3><p>Mulai tulis berita pertama sesuai kategori yang diinginkan.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap"><?php echo e($articles->links()); ?></div>

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
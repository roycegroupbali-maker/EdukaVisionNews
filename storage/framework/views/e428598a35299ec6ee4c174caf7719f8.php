<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Dashboard','pageSubtitle' => 'Ringkasan konten dan iklan EdukaVisionNews']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Ringkasan konten dan iklan EdukaVisionNews')]); ?>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-label">Total Berita</div>
      <div class="stat-value"><?php echo e($totalArticles); ?></div>
      <div class="stat-note"><?php echo e($publishedArticles); ?> tayang · <?php echo e($draftArticles); ?> draf</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Tayang</div>
      <div class="stat-value"><?php echo e($publishedArticles); ?></div>
      <div class="stat-note">Sudah bisa dibaca publik</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Iklan</div>
      <div class="stat-value"><?php echo e($totalAds); ?></div>
      <div class="stat-note"><?php echo e($activeAds); ?> sedang aktif tayang</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Kategori</div>
      <div class="stat-value"><?php echo e($articlesPerCategory->count()); ?></div>
      <div class="stat-note">Rubrik yang tersedia</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Pengajuan Berita</div>
      <div class="stat-value"><?php echo e($pendingSubmissions); ?></div>
      <div class="stat-note">
        <?php if($pendingSubmissions > 0): ?>
          <a href="<?php echo e(route('admin.news-submissions.index')); ?>">Menunggu ditinjau &rarr;</a>
        <?php else: ?>
          Tidak ada yang menunggu
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head">
          <h2>Berita Terbaru Diinput</h2>
          <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-accent btn-sm">+ Tulis Berita</a>
        </div>
        <div class="panel-body">
          <?php $__empty_1 = true; $__currentLoopData = $latestArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="category-bar-row" style="align-items:flex-start;">
              <div style="flex:1;">
                <a href="<?php echo e(route('admin.articles.edit', $a)); ?>" style="font-weight:600; color:var(--ink);"><?php echo e($a->title); ?></a>
                <div style="font-size:12px; color:var(--muted-2); margin-top:2px;">
                  <?php echo e($a->category->name ?? '—'); ?> · <?php echo e($a->created_at->translatedFormat('d M Y, H:i')); ?>

                  <?php if(!$a->published_at): ?> · <span class="badge badge-gray">Draf</span> <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada berita.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Berita Paling Banyak Dibaca</h2></div>
        <div class="panel-body">
          <?php $__empty_1 = true; $__currentLoopData = $mostViewed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="category-bar-row">
              <div style="flex:1;">
                <a href="<?php echo e(route('admin.articles.edit', $a)); ?>" style="font-weight:600; color:var(--ink);"><?php echo e($a->title); ?></a>
              </div>
              <div class="cbr-count" style="font-size:12.5px; color:var(--muted);"><?php echo e(number_format($a->views)); ?> views</div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada data.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Berita Paling Banyak Dibagikan</h2></div>
        <div class="panel-body">
          <?php $__empty_1 = true; $__currentLoopData = $mostShared; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="category-bar-row">
              <div style="flex:1;">
                <a href="<?php echo e(route('admin.articles.edit', $a)); ?>" style="font-weight:600; color:var(--ink);"><?php echo e($a->title); ?></a>
              </div>
              <div class="cbr-count" style="font-size:12.5px; color:var(--muted);"><?php echo e(number_format($a->shares)); ?> share</div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="color:var(--muted); font-size:13.5px; padding:14px 0;">Belum ada data.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="panel">
        <div class="panel-head"><h2>Berita per Kategori</h2></div>
        <div class="panel-body">
          <?php $max = max(1, $articlesPerCategory->max('articles_count')); ?>
          <?php $__currentLoopData = $articlesPerCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="category-bar-row">
              <div class="cbr-name"><?php echo e($cat->name); ?></div>
              <div class="category-bar-track">
                <div class="category-bar-fill" style="width:<?php echo e($cat->articles_count > 0 ? max(6, ($cat->articles_count / $max) * 100) : 0); ?>%;"></div>
              </div>
              <div class="category-bar-count"><?php echo e($cat->articles_count); ?></div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head"><h2>Aksi Cepat</h2></div>
        <div class="panel-body" style="display:flex; flex-direction:column; gap:10px; padding-bottom:20px;">
          <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-primary btn-block">+ Tulis Berita Baru</a>
          <a href="<?php echo e(route('admin.ads.create')); ?>" class="btn btn-ghost btn-block">+ Upload Iklan Baru</a>
          <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-ghost btn-block">Kelola Kategori</a>
        </div>
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
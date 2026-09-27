<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => ['pageTitle' => 'Laporan Statistik','pageSubtitle' => 'Akumulasi views &amp; share per minggu, bulan, atau tahun']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Laporan Statistik'),'page-subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Akumulasi views &amp; share per minggu, bulan, atau tahun')]); ?>

  <?php
    $f = $report['filters'];
    $months = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
  ?>

  <div class="filter-bar">
    <form method="GET" action="<?php echo e(route('admin.stats.index')); ?>" id="statFilterForm" style="display:flex; gap:10px; flex-wrap:wrap; flex:1; align-items:center;">
      <select name="period" onchange="statToggle(this.value); this.form.submit()">
        <option value="week" <?php if($f['period']==='week'): echo 'selected'; endif; ?>>Mingguan</option>
        <option value="month" <?php if($f['period']==='month'): echo 'selected'; endif; ?>>Bulanan</option>
        <option value="year" <?php if($f['period']==='year'): echo 'selected'; endif; ?>>Tahunan</option>
      </select>

      <input type="date" name="date" value="<?php echo e($f['date']); ?>" data-period="week"
             style="<?php echo e($f['period']==='week' ? '' : 'display:none;'); ?>" onchange="this.form.submit()">

      <select name="month" data-period="month" style="<?php echo e($f['period']==='month' ? '' : 'display:none;'); ?>" onchange="this.form.submit()">
        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($num); ?>" <?php if((int)$f['month']===(int)$num): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <select name="year" data-period="month year" style="<?php echo e($f['period']==='week' ? 'display:none;' : ''); ?>" onchange="this.form.submit()">
        <?php $__currentLoopData = $report['years']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($y); ?>" <?php if((int)$f['year']===(int)$y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <select name="category" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($c->slug); ?>" <?php if($f['category'] === $c->slug): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <select name="sort" onchange="this.form.submit()">
        <option value="views" <?php if($f['sort']==='views'): echo 'selected'; endif; ?>>Urutkan: Views terbanyak</option>
        <option value="shares" <?php if($f['sort']==='shares'): echo 'selected'; endif; ?>>Urutkan: Share terbanyak</option>
        <option value="total" <?php if($f['sort']==='total'): echo 'selected'; endif; ?>>Urutkan: Total terbanyak</option>
      </select>

      <?php if(request()->anyFilled(['category']) || $f['sort'] !== 'views'): ?>
        <a href="<?php echo e(route('admin.stats.index', ['period' => $f['period']])); ?>" class="btn btn-ghost btn-sm">Reset</a>
      <?php endif; ?>
    </form>

    <div style="display:flex; gap:8px;">
      <a href="<?php echo e(route('admin.stats.export.excel', request()->query())); ?>" class="btn btn-ghost btn-sm">&#8681; Excel</a>
      <a href="<?php echo e(route('admin.stats.export.pdf', request()->query())); ?>" class="btn btn-ghost btn-sm">&#8681; PDF</a>
    </div>
  </div>

  <script>
    function statToggle(period) {
      document.querySelectorAll('#statFilterForm [data-period]').forEach(function (el) {
        el.style.display = el.dataset.period.split(' ').includes(period) ? '' : 'none';
      });
    }
  </script>

  <div class="panel" style="padding:18px 22px; margin-bottom:22px;">
    <div style="font-family:'Fraunces', serif; font-size:17px; color:var(--ink);"><?php echo e($report['periodName']); ?> &middot; <?php echo e($report['label']); ?></div>
    <?php if($report['category']): ?>
      <div style="font-size:12.5px; color:var(--muted); margin-top:2px;">Kategori: <?php echo e($report['category']->name); ?></div>
    <?php endif; ?>
    <?php if($report['firstDateLabel']): ?>
      <div style="font-size:11.5px; color:var(--muted-2); margin-top:6px;">Rekap harian tercatat sejak <?php echo e($report['firstDateLabel']); ?>. Data sebelum tanggal itu tidak dapat dipecah per periode.</div>
    <?php endif; ?>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-label">Total Views</div>
      <div class="stat-value"><?php echo e(number_format($report['totals']['views'])); ?></div>
      <div class="stat-note">Pada periode terpilih</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Share</div>
      <div class="stat-value"><?php echo e(number_format($report['totals']['shares'])); ?></div>
      <div class="stat-note">Pada periode terpilih</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Aktif</div>
      <div class="stat-value"><?php echo e(number_format($report['totals']['articles'])); ?></div>
      <div class="stat-note">Punya minimal 1 views/share</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Berita Teratas</div>
      <div class="stat-value" style="font-size:15px; line-height:1.4;"><?php echo e($report['top']->title ?? '—'); ?></div>
      <div class="stat-note"><?php if($report['top']): ?><?php echo e(number_format($report['top']->period_total)); ?> total interaksi <?php else: ?> Belum ada data <?php endif; ?></div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head"><h2>Tren <?php echo e($report['filters']['period'] === 'year' ? 'per Bulan' : 'per Hari'); ?></h2></div>
    <div class="panel-body">
      <div style="position:relative; height:280px;">
        <canvas id="chartStatTrend"></canvas>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <h2>Akumulasi per Berita</h2>
      <span style="font-size:12px; color:var(--muted-2);"><?php echo e($report['sortLabel']); ?></span>
    </div>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Views</th>
            <th>Share</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $report['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="title-cell"><a href="<?php echo e(route('admin.articles.edit', $a)); ?>"><?php echo e($a->title); ?></a></td>
              <td><?php echo e($a->category->name ?? '—'); ?></td>
              <td><?php echo e(number_format($a->period_views)); ?></td>
              <td><?php echo e(number_format($a->period_shares)); ?></td>
              <td><?php echo e(number_format($a->period_total)); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5"><div class="empty-state"><h3>Belum ada aktivitas</h3><p>Tidak ada views atau share yang tercatat pada periode ini.</p></div></td></tr>
          <?php endif; ?>
        </tbody>
        <?php if($report['rows']->isNotEmpty()): ?>
          <tfoot>
            <tr style="font-weight:700; background:var(--paper-alt);">
              <td colspan="2">Total (<?php echo e($report['totals']['articles']); ?> berita)</td>
              <td><?php echo e(number_format($report['totals']['views'])); ?></td>
              <td><?php echo e(number_format($report['totals']['shares'])); ?></td>
              <td><?php echo e(number_format($report['totals']['total'])); ?></td>
            </tr>
          </tfoot>
        <?php endif; ?>
      </table>
    </div>
  </div>

  <script type="application/json" id="stat-trend-data">
    <?php echo json_encode([
      'labels' => $report['trend']['labels'],
      'views' => $report['trend']['views'],
      'shares' => $report['trend']['shares'],
    ]); ?>

  </script>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/js/admin/stat-report-chart.js']); ?>

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
<?php /**PATH D:\web\EdukaVisionNews\resources\views/admin/stats/index.blade.php ENDPATH**/ ?>
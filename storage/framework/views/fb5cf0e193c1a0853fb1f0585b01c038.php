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
            <input type="file" id="adImageInput" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <div class="field-hint">Format JPG/PNG/WEBP/GIF, maksimal 20MB. <?php echo e($isEdit ? 'Kosongkan jika tidak ingin mengganti gambar.' : ''); ?></div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          
          <?php
            $fitVal = old('fit', $ad->fit ?: 'cover');
            $xVal = (int) old('pos_x', $ad->pos_x ?? 50);
            $yVal = (int) old('pos_y', $ad->pos_y ?? 50);
            $zVal = (int) old('zoom', $ad->zoom ?? 100);
          ?>
          <div class="field">
            <label>Atur Tampilan Gambar</label>
            <div class="ad-editor" id="adEditor" data-ratios='<?php echo json_encode(\App\Models\Ad::SLOT_RATIOS, 15, 512) ?>'>
              <div class="ad-editor-frame" id="adEditorFrame" style="--ad-ratio: 970 / 90;">
                <img id="adImagePreview" src="<?php echo e($isEdit && $ad->image_path ? $ad->image_url : ''); ?>" alt="<?php echo e($ad->title); ?>" draggable="false" style="<?php echo e($isEdit && $ad->image_path ? '' : 'display:none;'); ?>">
                <span class="ad-editor-empty" id="adEditorEmpty" <?php if($isEdit && $ad->image_path): ?> style="display:none;" <?php endif; ?>>Pilih gambar untuk melihat pratinjau</span>
              </div>
              <div class="field-hint">Tarik (drag) gambar di dalam bingkai untuk menggeser posisinya. Bingkai mengikuti ukuran slot yang dipilih.</div>

              <div class="ad-editor-controls">
                <div class="field">
                  <label for="adFit">Cara gambar mengisi bingkai</label>
                  <select id="adFit" name="fit">
                    <?php $__currentLoopData = \App\Models\Ad::FITS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($k); ?>" <?php if($fitVal === $k): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="field">
                  <label for="adZoom">Zoom: <span id="adZoomVal"><?php echo e($zVal); ?></span>%</label>
                  <input type="range" id="adZoom" name="zoom" min="100" max="300" step="5" value="<?php echo e($zVal); ?>">
                </div>
                <div class="field">
                  <label for="adPosX">Posisi kiri–kanan: <span id="adPosXVal"><?php echo e($xVal); ?></span>%</label>
                  <input type="range" id="adPosX" name="pos_x" min="0" max="100" value="<?php echo e($xVal); ?>">
                </div>
                <div class="field">
                  <label for="adPosY">Posisi atas–bawah: <span id="adPosYVal"><?php echo e($yVal); ?></span>%</label>
                  <input type="range" id="adPosY" name="pos_y" min="0" max="100" value="<?php echo e($yVal); ?>">
                </div>
              </div>
              <button type="button" class="btn btn-ghost" id="adEditorReset">Reset ke tengah</button>
            </div>
            <?php $__errorArgs = ['fit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['zoom'];
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

  <script>
  (function () {
    var editor = document.getElementById('adEditor');
    if (!editor) return;
    var ratios = JSON.parse(editor.getAttribute('data-ratios'));
    var frame = document.getElementById('adEditorFrame');
    var img = document.getElementById('adImagePreview');
    var empty = document.getElementById('adEditorEmpty');
    var slot = document.getElementById('adSlot');
    var fit = document.getElementById('adFit');
    var zoom = document.getElementById('adZoom');
    var px = document.getElementById('adPosX');
    var py = document.getElementById('adPosY');
    var labels = { zoom: document.getElementById('adZoomVal'), x: document.getElementById('adPosXVal'), y: document.getElementById('adPosYVal') };

    function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

    function apply() {
      var x = +px.value, y = +py.value, z = +zoom.value / 100;
      img.style.objectFit = fit.value;
      img.style.objectPosition = x + '% ' + y + '%';
      img.style.transformOrigin = x + '% ' + y + '%';
      img.style.transform = 'scale(' + z + ')';
      labels.zoom.textContent = zoom.value;
      labels.x.textContent = x;
      labels.y.textContent = y;
      var has = img.getAttribute('src');
      empty.style.display = has ? 'none' : '';
    }

    function applyRatio() {
      var r = ratios[slot.value] || ratios.leaderboard;
      frame.style.setProperty('--ad-ratio', r.desktop);
    }

    [fit, zoom, px, py].forEach(function (el) { el.addEventListener('input', apply); });
    slot.addEventListener('change', applyRatio);
    document.getElementById('adImageInput').addEventListener('change', function () { setTimeout(apply, 50); });

    document.getElementById('adEditorReset').addEventListener('click', function () {
      px.value = 50; py.value = 50; zoom.value = 100; fit.value = 'cover'; apply();
    });

    // Tarik gambar untuk menggeser titik fokus
    var drag = null;
    frame.addEventListener('pointerdown', function (e) {
      if (!img.getAttribute('src')) return;
      drag = { x: e.clientX, y: e.clientY, px: +px.value, py: +py.value };
      frame.setPointerCapture(e.pointerId);
      frame.classList.add('dragging');
    });
    frame.addEventListener('pointermove', function (e) {
      if (!drag) return;
      var rect = frame.getBoundingClientRect();
      // Tarik ke kanan = bagian kiri gambar terlihat (nilai % turun), seperti menggeser kertas.
      px.value = clamp(Math.round(drag.px - (e.clientX - drag.x) / rect.width * 100), 0, 100);
      py.value = clamp(Math.round(drag.py - (e.clientY - drag.y) / rect.height * 100), 0, 100);
      apply();
    });
    function end() { drag = null; frame.classList.remove('dragging'); }
    frame.addEventListener('pointerup', end);
    frame.addEventListener('pointercancel', end);

    applyRatio();
    apply();
  })();
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
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/admin/ads/form.blade.php ENDPATH**/ ?>
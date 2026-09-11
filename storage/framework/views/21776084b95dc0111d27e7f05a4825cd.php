<?php echo $__env->make('partials.header', [
    'pageTitle' => 'Ajukan Berita — EdukaVisionNews',
    'pageDescription' => 'Kirim usulan berita, laporan warga, atau info kejadian di sekitarmu ke redaksi EdukaVisionNews.',
    'categories' => $categories,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="section-band news-submission-page">
  <div class="wrap" style="max-width:720px;">

    <div class="section-head" style="border:none; margin-bottom:6px;">
      <h2 class="section-title" style="border:none;"><span class="bar"></span> Ajukan Berita</h2>
    </div>
    <p class="news-submission-lead">
      Punya info, kejadian, atau kegiatan yang menurutmu layak diberitakan? Isi formulir di bawah ini.
      Tim redaksi kami akan meninjau setiap pengajuan yang masuk sebelum diangkat menjadi berita.
    </p>
    <p class="news-submission-lead" style="margin-top:-18px;">
      Sudah pernah mengirim usulan berita? <a href="<?php echo e(route('news-submission.track')); ?>" class="ns-track-link">Lacak status pengajuanmu di sini &rarr;</a>
    </p>

    <?php if(session('status')): ?>
      <div class="ns-alert ns-alert-success">
        <?php echo e(session('status')); ?>

        <strong style="color:#d92626;">Pastikan juga cek folder Spam/Promosi di email kamu ya.</strong>
      </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
      <div class="ns-alert ns-alert-error">
        <strong>Ada isian yang perlu diperbaiki:</strong>
        <ul>
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('news-submission.store')); ?>" enctype="multipart/form-data" class="ns-form">
      <?php echo csrf_field(); ?>

      <div class="ns-row">
        <div class="ns-field">
          <label for="nsName">Nama Kamu</label>
          <input type="text" id="nsName" name="name" value="<?php echo e(old('name')); ?>" required maxlength="100" placeholder="Nama lengkap">
        </div>
        <div class="ns-field">
          <label for="nsEmail">Email</label>
          <input type="email" id="nsEmail" name="email" value="<?php echo e(old('email')); ?>" required maxlength="150" placeholder="email@contoh.com">
        </div>
      </div>

      <div class="ns-field">
        <label for="nsPhone">Nomor Telepon / WhatsApp</label>
        <input type="tel" id="nsPhone" name="phone" value="<?php echo e(old('phone')); ?>" required maxlength="20" placeholder="mis. 081234567890">
        <div class="ns-hint">Dipakai tim redaksi untuk menghubungimu jika diperlukan konfirmasi lebih lanjut.</div>
      </div>

      <div class="ns-field">
        <label for="nsTitle">Judul Usulan Berita</label>
        <input type="text" id="nsTitle" name="title" value="<?php echo e(old('title')); ?>" required maxlength="255" placeholder="mis. Banjir Rendam Permukiman di Kelurahan Sanur">
      </div>

      <div class="ns-field">
        <label for="nsContent">Isi / Ringkasan Berita</label>
        <textarea id="nsContent" name="content" required maxlength="5000" placeholder="Ceritakan kronologi, lokasi, waktu kejadian, dan pihak-pihak yang terlibat sejelas mungkin…"><?php echo e(old('content')); ?></textarea>
        <div class="ns-hint">Maksimal 5000 karakter. Semakin lengkap informasi yang kamu berikan, semakin mudah tim redaksi menindaklanjuti.</div>
      </div>

      <div class="ns-field">
        <label for="nsImage">Lampiran Foto <span class="ns-optional">(opsional)</span></label>

        <div class="ns-dropzone" id="nsDropzone" tabindex="0" role="button" aria-label="Pilih file foto">
          <input type="file" id="nsImage" name="image" accept="image/png,image/jpeg,image/webp,image/gif" class="ns-dropzone-input">

          <div class="ns-dropzone-empty" id="nsDropzoneEmpty">
            <svg class="ns-dropzone-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 16V4M12 4L7 9M12 4L17 9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M4 16V18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="ns-dropzone-text">
              <strong>Klik untuk pilih file</strong><br>atau tarik &amp; lepas foto ke sini
            </div>
            <span class="ns-dropzone-btn">Telusuri File</span>
          </div>

          <div class="ns-dropzone-filled" id="nsDropzoneFilled" style="display:none;">
            <div class="ns-dropzone-file-info">
              <svg class="ns-dropzone-file-icon" width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 2H14L20 8V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V4C4 2.89543 4.89543 2 6 2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M14 2V8H20" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
              </svg>
              <div>
                <div class="ns-dropzone-filename" id="nsDropzoneFilename"></div>
                <div class="ns-dropzone-filesize" id="nsDropzoneFilesize"></div>
              </div>
            </div>
            <button type="button" class="ns-dropzone-remove" id="nsDropzoneRemove" aria-label="Hapus file yang dipilih">&times;</button>
          </div>
        </div>

        <div class="ns-hint">Format JPG/PNG/WEBP/GIF, maksimal 8MB.</div>
      </div>

      <button type="submit" class="ns-submit-btn">Kirim Usulan Berita</button>
    </form>

  </div>
</section>

<script>
(function () {
  var dropzone = document.getElementById('nsDropzone');
  var input = document.getElementById('nsImage');
  var empty = document.getElementById('nsDropzoneEmpty');
  var filled = document.getElementById('nsDropzoneFilled');
  var filenameEl = document.getElementById('nsDropzoneFilename');
  var filesizeEl = document.getElementById('nsDropzoneFilesize');
  var removeBtn = document.getElementById('nsDropzoneRemove');

  function formatSize(bytes) {
    if (bytes >= 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    return Math.round(bytes / 1024) + ' KB';
  }

  function showFile(file) {
    filenameEl.textContent = file.name;
    filesizeEl.textContent = formatSize(file.size);
    empty.style.display = 'none';
    filled.style.display = 'flex';
    dropzone.classList.add('has-file');
  }

  function clearFile() {
    input.value = '';
    empty.style.display = 'flex';
    filled.style.display = 'none';
    dropzone.classList.remove('has-file');
  }

  // Klik di mana saja pada dropzone (selain tombol hapus) membuka dialog pilih file.
  dropzone.addEventListener('click', function () {
    input.click();
  });
  dropzone.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      input.click();
    }
  });

  input.addEventListener('change', function () {
    if (input.files && input.files.length > 0) {
      showFile(input.files[0]);
    } else {
      clearFile();
    }
  });

  removeBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    clearFile();
  });

  // Drag & drop
  ['dragenter', 'dragover'].forEach(function (evt) {
    dropzone.addEventListener(evt, function (e) {
      e.preventDefault();
      e.stopPropagation();
      dropzone.classList.add('is-dragover');
    });
  });
  ['dragleave', 'drop'].forEach(function (evt) {
    dropzone.addEventListener(evt, function (e) {
      e.preventDefault();
      e.stopPropagation();
      dropzone.classList.remove('is-dragover');
    });
  });
  dropzone.addEventListener('drop', function (e) {
    var files = e.dataTransfer.files;
    if (files && files.length > 0) {
      input.files = files;
      showFile(files[0]);
    }
  });
})();
</script>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/news-submission/create.blade.php ENDPATH**/ ?>
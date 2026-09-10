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
      <div class="ns-alert ns-alert-success"><?php echo e(session('status')); ?></div>
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
        <input type="file" id="nsImage" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
        <div class="ns-hint">Format JPG/PNG/WEBP/GIF, maksimal 8MB.</div>
      </div>

      <button type="submit" class="ns-submit-btn">Kirim Usulan Berita</button>
    </form>

  </div>
</section>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/news-submission/create.blade.php ENDPATH**/ ?>
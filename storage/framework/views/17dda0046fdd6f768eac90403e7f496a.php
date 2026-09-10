<?php echo $__env->make('partials.header', [
    'pageTitle' => 'Lacak Pengajuan Berita — EdukaVisionNews',
    'pageDescription' => 'Cek status usulan berita yang kamu kirimkan ke redaksi EdukaVisionNews menggunakan nomor tiket dan email.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="section-band news-submission-page">
  <div class="wrap" style="max-width:720px;">

    <div class="section-head" style="border:none; margin-bottom:6px;">
      <h2 class="section-title" style="border:none;"><span class="bar"></span> Lacak Pengajuan Berita</h2>
    </div>
    <p class="news-submission-lead">
      Masukkan nomor tiket dan email yang kamu gunakan saat mengirim usulan berita untuk melihat status
      terbaru dan catatan dari tim redaksi.
    </p>

    <form method="GET" action="<?php echo e(route('news-submission.track')); ?>" class="ns-form ns-track-form">
      <div class="ns-row">
        <div class="ns-field">
          <label for="nsTicket">Nomor Tiket</label>
          <input type="text" id="nsTicket" name="ticket" value="<?php echo e(old('ticket', request('ticket'))); ?>" required maxlength="20" placeholder="mis. 00001 atau #00001">
          <div class="ns-hint">Bisa dilihat di email konfirmasi yang kami kirim saat kamu mengajukan berita.</div>
        </div>
        <div class="ns-field">
          <label for="nsTrackEmail">Email</label>
          <input type="email" id="nsTrackEmail" name="email" value="<?php echo e(old('email', request('email'))); ?>" required maxlength="150" placeholder="email@contoh.com">
        </div>
      </div>

      <?php if($errors->any()): ?>
        <div class="ns-alert ns-alert-error">
          <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <button type="submit" class="ns-submit-btn">Lacak Status</button>
    </form>

    <?php if($notFound): ?>
      <div class="ns-alert ns-alert-error" style="margin-top:24px;">
        Data tidak ditemukan. Pastikan nomor tiket dan email yang kamu masukkan sesuai dengan yang tercantum
        di email konfirmasi pengajuan berita.
      </div>
    <?php endif; ?>

    <?php if($submission): ?>
      <?php
        $steps = [
          \App\Models\NewsSubmission::STATUS_PENDING => 'Diterima',
          \App\Models\NewsSubmission::STATUS_REVIEWED => 'Ditinjau',
          $submission->status === \App\Models\NewsSubmission::STATUS_REJECTED
            ? \App\Models\NewsSubmission::STATUS_REJECTED
            : \App\Models\NewsSubmission::STATUS_APPROVED
              => $submission->status === \App\Models\NewsSubmission::STATUS_REJECTED ? 'Ditolak' : 'Disetujui',
        ];
        $stepKeys = array_keys($steps);
        $currentIndex = array_search($submission->status, $stepKeys);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        $isRejected = $submission->status === \App\Models\NewsSubmission::STATUS_REJECTED;
      ?>

      <div class="ns-track-result">
        <div class="ns-track-head">
          <div>
            <div class="ns-track-ticket">Tiket #<?php echo e(str_pad($submission->id, 5, '0', STR_PAD_LEFT)); ?></div>
            <div class="ns-track-title"><?php echo e($submission->title); ?></div>
          </div>
          <span class="ns-track-badge" style="background-color:<?php echo e($submission->status_color['bg']); ?>; color:<?php echo e($submission->status_color['text']); ?>; border-color:<?php echo e($submission->status_color['border']); ?>;">
            <?php echo e($submission->status_label); ?>

          </span>
        </div>

        <div class="ns-track-meta">
          <div>
            <span>Dikirim</span>
            <strong><?php echo e($submission->created_at->translatedFormat('d M Y, H:i')); ?></strong>
          </div>
          <div>
            <span>Diperbarui</span>
            <strong><?php echo e($submission->updated_at->translatedFormat('d M Y, H:i')); ?></strong>
          </div>
        </div>

        <!-- Timeline status -->
        <div class="ns-track-timeline <?php echo e($isRejected ? 'is-rejected' : ''); ?>">
          <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $stepIndex = array_search($key, $stepKeys);
              $state = $stepIndex < $currentIndex ? 'done' : ($stepIndex === $currentIndex ? 'current' : 'upcoming');
            ?>
            <div class="ns-track-step ns-track-step--<?php echo e($state); ?>">
              <div class="ns-track-dot"></div>
              <div class="ns-track-step-label"><?php echo e($label); ?></div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($submission->admin_note): ?>
          <div class="ns-track-note">
            <div class="ns-track-note-label">Catatan dari Redaksi</div>
            <p><?php echo e($submission->admin_note); ?></p>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/news-submission/track.blade.php ENDPATH**/ ?>
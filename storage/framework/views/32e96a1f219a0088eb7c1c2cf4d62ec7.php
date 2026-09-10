<?php
  $color = $submission->status_color;
  $messages = [
    'pending' => 'Permohonan berita kamu saat ini berada dalam antrean dan menunggu untuk ditinjau oleh tim redaksi kami.',
    'reviewed' => 'Kabar baik! Permohonan berita kamu sudah dibaca dan sedang dalam proses peninjauan lebih lanjut oleh tim redaksi.',
    'approved' => 'Selamat! Usulan beritamu disetujui oleh tim redaksi dan akan diproses untuk diangkat menjadi berita di EdukaVisionNews.',
    'rejected' => 'Setelah melalui proses peninjauan, tim redaksi kami belum dapat mengangkat usulan berita ini untuk saat ini.',
  ];
  $heading = [
    'pending' => 'Permohonan Beritamu Masuk Antrean',
    'reviewed' => 'Permohonan Beritamu Sedang Ditinjau',
    'approved' => 'Usulan Beritamu Disetujui!',
    'rejected' => 'Update Untuk Usulan Beritamu',
  ];
?>

<?php $__env->startSection('title', 'Update Status Usulan Berita — EdukaVisionNews'); ?>
<?php $__env->startSection('eyebrow', 'Update Status Permohonan Berita'); ?>
<?php $__env->startSection('preheader', 'Status usulan berita "'.$submission->title.'" diperbarui menjadi '.$submission->status_label.'.'); ?>

<?php $__env->startSection('content'); ?>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
    <tr>
      <td>
        <span style="display:inline-block; background-color:<?php echo e($color['bg']); ?>; color:<?php echo e($color['text']); ?>; border:1px solid <?php echo e($color['border']); ?>; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">
          Status Terbaru: <?php echo e($submission->status_label); ?>

        </span>
      </td>
    </tr>
  </table>

  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:23px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">
    Halo <?php echo e($submission->name); ?>, <?php echo e($heading[$submission->status] ?? 'Status Usulan Beritamu Diperbarui'); ?>

  </h1>

  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 26px;">
    <?php echo e($messages[$submission->status] ?? 'Status permohonan berita yang kamu kirimkan telah diperbarui oleh tim redaksi kami.'); ?>

  </p>

  <!-- Submission detail card -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF8F3; border:1px solid #e4ddcd; margin-bottom:22px;">
    <tr>
      <td style="padding:22px 24px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="font-family:'Courier New', monospace; font-size:10.5px; letter-spacing:0.1em; text-transform:uppercase; color:#8f8a7c; padding-bottom:4px;">Judul Usulan Berita</td>
          </tr>
          <tr>
            <td style="font-family:'Georgia','Times New Roman',serif; font-size:17px; color:#0D1B3A; font-weight:700; padding-bottom:16px; line-height:1.4;"><?php echo e($submission->title); ?></td>
          </tr>
        </table>

        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e4ddcd; padding-top:14px;">
          <tr>
            <td width="50%" valign="top" style="font-family:'Helvetica Neue', Arial, sans-serif;">
              <div style="font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; margin-bottom:3px;">Nomor Tiket</div>
              <div style="font-size:13.5px; color:#22262B; font-weight:600;">#<?php echo e(str_pad($submission->id, 5, '0', STR_PAD_LEFT)); ?></div>
            </td>
            <td width="50%" valign="top" style="font-family:'Helvetica Neue', Arial, sans-serif;">
              <div style="font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; margin-bottom:3px;">Diperbarui</div>
              <div style="font-size:13.5px; color:#22262B; font-weight:600;"><?php echo e($submission->updated_at->translatedFormat('d M Y, H:i')); ?></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <?php if($submission->admin_note): ?>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF1DC; border:1px solid #e9d9ab; margin-bottom:26px;">
      <tr>
        <td style="padding:18px 22px;">
          <div style="font-family:'Courier New', monospace; font-size:10.5px; letter-spacing:0.1em; text-transform:uppercase; color:#86671A; margin-bottom:6px;">Catatan Dari Redaksi</div>
          <div style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; line-height:1.7; color:#3d3a33; white-space:pre-line;"><?php echo e($submission->admin_note); ?></div>
        </td>
      </tr>
    </table>
  <?php endif; ?>

  <?php if($submission->status === 'rejected'): ?>
    <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; line-height:1.75; color:#3d3a33; margin:0 0 26px;">
      Jangan berkecil hati — kamu tetap bisa mengirimkan usulan berita lain kapan saja lewat formulir Permohonan Berita di situs kami.
    </p>
  <?php elseif($submission->status === 'approved'): ?>
    <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; line-height:1.75; color:#3d3a33; margin:0 0 26px;">
      Tim redaksi kami mungkin akan menghubungimu lewat email atau nomor telepon yang kamu cantumkan apabila ada informasi tambahan yang diperlukan sebelum berita tayang.
    </p>
  <?php endif; ?>

  <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
    <tr>
      <td style="background-color:#0D1B3A; border-radius:3px;">
        <a href="<?php echo e(url('/')); ?>" class="ev-btn" style="display:inline-block; font-family:'Helvetica Neue', Arial, sans-serif; font-size:13px; font-weight:600; color:#FFFFFF; padding:12px 26px; letter-spacing:0.02em;">Kunjungi EdukaVisionNews &rarr;</a>
      </td>
    </tr>
  </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/emails/news-submission/status-updated.blade.php ENDPATH**/ ?>
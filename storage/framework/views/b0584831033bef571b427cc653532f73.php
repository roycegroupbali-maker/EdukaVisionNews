<?php $__env->startSection('title', 'Verifikasi Email — EdukaVisionNews'); ?>
<?php $__env->startSection('eyebrow', 'Verifikasi Email'); ?>
<?php $__env->startSection('preheader', 'Konfirmasi bahwa email ini benar milik Anda.'); ?>
<?php $__env->startSection('footer_note'); ?>
Email ini dikirim otomatis oleh sistem EdukaVisionNews terkait akun panel admin Anda. Mohon tidak membalas langsung ke alamat email ini.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:24px; line-height:1.35; color:#0D1B3A; margin:0 0 14px;">Halo, <?php echo e($user->name); ?>.<br>Verifikasi email Anda.</h1>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14.5px; line-height:1.75; color:#3d3a33; margin:0 0 22px;">Anda meminta verifikasi untuk email akun panel admin <strong><?php echo e($user->email); ?></strong>. Klik tombol di bawah untuk mengonfirmasi. Login Anda tidak terpengaruh, verifikasi ini hanya menandai email sebagai terkonfirmasi.</p>
  <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
    <tr><td style="background-color:#0D1B3A; border-radius:3px;">
      <a href="<?php echo e($url); ?>" class="ev-btn" style="display:inline-block; font-family:'Helvetica Neue', Arial, sans-serif; font-size:13px; font-weight:600; color:#FFFFFF; padding:12px 26px; letter-spacing:0.02em;">Verifikasi Email Saya &rarr;</a>
    </td></tr>
  </table>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; line-height:1.7; color:#6b675c; margin:0 0 16px;">Tautan ini hanya berlaku <strong><?php echo e($expireMinutes); ?> menit</strong>.</p>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; line-height:1.7; color:#6b675c; margin:0 0 16px;">Jika tombol tidak berfungsi, salin dan tempel alamat berikut ke peramban Anda:<br><span style="word-break:break-all; color:#0D1B3A;"><?php echo e($url); ?></span></p>
  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; line-height:1.7; color:#6b675c; margin:0 0 16px;"><strong>Tidak merasa meminta ini?</strong> Abaikan email ini, tidak ada yang berubah pada akun Anda. Kami tidak pernah meminta atau mengirim kata sandi Anda lewat email. Anda perlu login ke panel admin saat membuka tautan ini.</p>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/emails/admin/verify-email.blade.php ENDPATH**/ ?>
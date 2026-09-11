<?php $__env->startSection('title', 'Permohonan Berita Baru — EdukaVisionNews'); ?>
<?php $__env->startSection('eyebrow', 'Notifikasi Admin'); ?>
<?php $__env->startSection('preheader', 'Permohonan berita baru masuk dari '.e($submission->name).': "'.e($submission->title).'"'); ?>

<?php $__env->startSection('content'); ?>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
    <tr>
      <td>
        <span style="display:inline-block; background-color:#FBEAEA; color:#9c1e23; border:1px solid #f0c4c4; font-family:'Helvetica Neue', Arial, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; padding:6px 12px; border-radius:20px;">
          &#9679; Perlu Ditinjau
        </span>
      </td>
    </tr>
  </table>

  <h1 style="font-family:'Georgia','Times New Roman',serif; font-size:22px; line-height:1.35; color:#0D1B3A; margin:0 0 12px;">
    Ada permohonan berita baru masuk
  </h1>

  <p style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; line-height:1.75; color:#3d3a33; margin:0 0 24px;">
    Seorang pembaca mengirimkan usulan berita lewat formulir Permohonan Berita di situs. Ini detailnya:
  </p>

  <!-- Title strip -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:2px;">
    <tr>
      <td style="background-color:#0D1B3A; padding:16px 20px; border-radius:3px 3px 0 0;">
        <div style="font-family:'Courier New', monospace; font-size:10px; letter-spacing:0.12em; text-transform:uppercase; color:#9AA6C4; margin-bottom:5px;">Judul Usulan Berita</div>
        <div style="font-family:'Georgia','Times New Roman',serif; font-size:18px; color:#FFFFFF; font-weight:700; line-height:1.4;"><?php echo e($submission->title); ?></div>
      </td>
    </tr>
  </table>

  <!-- Field list -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBF8F3; border:1px solid #e4ddcd; border-top:none; margin-bottom:22px;">
    <tr>
      <td style="padding:4px 20px;">

        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c; width:110px;" valign="top">Pengirim</td>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; color:#22262B; font-weight:600;" valign="top"><?php echo e($submission->name); ?></td>
          </tr>
          <tr>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c;" valign="top">Email</td>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px;" valign="top"><a href="mailto:<?php echo e($submission->email); ?>" style="color:#0D1B3A; font-weight:600;"><?php echo e($submission->email); ?></a></td>
          </tr>
          <tr>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c;" valign="top">Telepon</td>
            <td style="padding:13px 0; border-bottom:1px solid #e4ddcd; font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px;" valign="top">
              <?php if($submission->phone): ?>
                <a href="tel:<?php echo e($submission->phone); ?>" style="color:#0D1B3A; font-weight:600;"><?php echo e($submission->phone); ?></a>
              <?php else: ?>
                <span style="color:#8f8a7c;">&mdash;</span>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td style="padding:13px 0; font-family:'Helvetica Neue', Arial, sans-serif; font-size:10.5px; letter-spacing:0.06em; text-transform:uppercase; color:#8f8a7c;" valign="top">Tiket</td>
            <td style="padding:13px 0; font-family:'Helvetica Neue', Arial, sans-serif; font-size:14px; color:#22262B; font-weight:600;" valign="top">#<?php echo e(str_pad($submission->id, 5, '0', STR_PAD_LEFT)); ?> &middot; <?php echo e($submission->created_at->translatedFormat('d M Y, H:i')); ?></td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

  <!-- Content preview (editorial pull-quote style) -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
    <tr>
      <td style="background-color:#FFFFFF; border:1px solid #e4ddcd; border-left:3px solid #B28923; padding:18px 22px;">
        <div style="font-family:'Courier New', monospace; font-size:10px; letter-spacing:0.12em; text-transform:uppercase; color:#8f8a7c; margin-bottom:8px;">Ringkasan Isi</div>
        <div style="font-family:'Georgia','Times New Roman',serif; font-style:italic; font-size:14.5px; line-height:1.75; color:#3d3a33; white-space:pre-line;">&ldquo;<?php echo e(\Illuminate\Support\Str::limit($submission->content, 400)); ?>&rdquo;</div>
      </td>
    </tr>
  </table>

  <table role="presentation" cellpadding="0" cellspacing="0">
    <tr>
      <td style="background-color:#0D1B3A; border-radius:3px;">
        <a href="<?php echo e(route('admin.news-submissions.show', $submission)); ?>" class="ev-btn" style="display:inline-block; font-family:'Helvetica Neue', Arial, sans-serif; font-size:13px; font-weight:600; color:#FFFFFF; padding:13px 28px; letter-spacing:0.02em;">Tinjau di Panel Admin &rarr;</a>
      </td>
      <td style="padding-left:12px; font-family:'Helvetica Neue', Arial, sans-serif; font-size:12.5px; color:#8f8a7c;" valign="middle">atau balas email pengirim langsung</td>
    </tr>
  </table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/emails/news-submission/admin-notification.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $__env->yieldContent('title', 'EdukaVisionNews'); ?></title>
<!--[if mso]>
<noscript>
  <xml>
    <o:OfficeDocumentSettings>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
  </xml>
</noscript>
<![endif]-->
<style>
  body, table, td { font-family: 'Georgia', 'Times New Roman', serif; }
  body { margin:0; padding:0; background-color:#F1ECE1; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
  table { border-collapse:collapse; }
  img { border:0; line-height:100%; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; }
  a { text-decoration:none; }
  .ev-btn:hover { opacity:0.92; }
  @media only screen and (max-width:620px) {
    .ev-container { width:100% !important; }
    .ev-px { padding-left:22px !important; padding-right:22px !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#F1ECE1;">
<!-- Preheader (hidden preview text) -->
<div style="display:none; max-height:0; overflow:hidden; opacity:0; mso-hide:all;">
  <?php echo $__env->yieldContent('preheader', 'EdukaVisionNews — Denyut Kabar Hari Ini'); ?>
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F1ECE1;">
  <tr>
    <td align="center" style="padding:40px 16px;">

      <table role="presentation" class="ev-container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#FFFFFF; border:1px solid #e4ddcd;">

        <!-- Header -->
        <tr>
          <td style="background-color:#0D1B3A; padding:26px 40px;" class="ev-px">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="middle" width="40">
                  <img src="<?php echo e($message->embed(public_path('images/logo-icon.png'))); ?>" width="34" height="34" alt="EdukaVisionNews" style="display:block; border-radius:3px;">
                </td>
                <td valign="middle" style="padding-left:12px;">
                  <span style="font-family:'Georgia','Times New Roman',serif; font-size:19px; font-weight:700; color:#FFFFFF; letter-spacing:0.2px;">Eduka<span style="color:#D2A63B;">Vision</span>News</span><br>
                  <span style="font-family:'Courier New', monospace; font-size:10px; letter-spacing:0.14em; text-transform:uppercase; color:#9AA6C4;">Denyut Kabar Hari Ini</span>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- Gold accent bar -->
        <tr>
          <td style="background-color:#B28923; font-size:0; line-height:4px; height:4px;">&nbsp;</td>
        </tr>

        <!-- Eyebrow strip -->
        <tr>
          <td style="background-color:#FBF8F3; padding:12px 40px; border-bottom:1px solid #e4ddcd;" class="ev-px">
            <span style="font-family:'Courier New', monospace; font-size:11px; letter-spacing:0.12em; text-transform:uppercase; color:#8f8a7c;"><?php echo $__env->yieldContent('eyebrow', 'Permohonan Berita'); ?></span>
          </td>
        </tr>

        <!-- Content -->
        <tr>
          <td style="padding:36px 40px 8px;" class="ev-px">
            <?php echo $__env->yieldContent('content'); ?>
          </td>
        </tr>

        <!-- Spacer -->
        <tr><td style="padding-top:20px;">&nbsp;</td></tr>

        <!-- Footer -->
        <tr>
          <td style="background-color:#0D1B3A; padding:26px 40px;" class="ev-px">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="font-family:'Helvetica Neue', Arial, sans-serif; font-size:12px; line-height:1.7; color:#9AA6C4;">
                  <strong style="color:#FFFFFF;">EdukaVisionNews</strong> — Portal berita harian: nasional, dunia, bisnis, olahraga, lifestyle, edukasi, dan resep masakan.<br>
                  Email ini dikirim otomatis oleh sistem kami sehubungan dengan formulir Permohonan Berita yang kamu isi. Mohon tidak membalas langsung ke alamat email ini.<br><br>
                  &copy; <?php echo e(date('Y')); ?> EdukaVisionNews. Seluruh hak cipta dilindungi.
                </td>
              </tr>
            </table>
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>
</body>
</html><?php /**PATH /Users/enb/Herd/EdukaVisionNews/resources/views/emails/layout.blade.php ENDPATH**/ ?>
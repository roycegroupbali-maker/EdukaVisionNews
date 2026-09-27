<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — EdukaVisionNews</title>
<meta name="robots" content="noindex, nofollow">
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin/admin.css', 'resources/js/admin/admin.js']); ?>
</head>
<body class="admin-body">

<div class="admin-auth">
  <div class="admin-auth-card">
    <div class="admin-auth-logo">
      <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="EdukaVisionNews" class="admin-auth-logo-img">
      <span class="logo-text">Eduka<span class="accent">Vision</span>News</span>
    </div>

    <h1>Login Panel Admin</h1>
    <p class="sub">Khusus redaksi &amp; pengelola iklan EdukaVisionNews. Masuk untuk mengelola berita dan slot iklan.</p>

    <?php if(session('status')): ?>
      <div class="admin-flash success" style="margin-bottom:16px;"><?php echo e(session('status')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
      <div class="admin-flash error" style="margin-bottom:16px;"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.login.attempt')); ?>">
      <?php echo csrf_field(); ?>
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="admin@edukavisionnews.test">
      </div>
      <div class="field">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <div class="field checkbox-field">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember" style="margin:0;">Ingat saya di perangkat ini</label>
      </div>
      <button type="submit" class="btn btn-accent btn-block">Masuk ke Panel Admin</button>
    </form>

    <p class="admin-auth-foot">
      Belum punya akun? <a href="<?php echo e(route('admin.register')); ?>">Daftar di sini</a>.
    </p>
    <p class="admin-auth-foot">© <?php echo e(now()->year); ?> EdukaVisionNews Media Group.</p>
  </div>
</div>

</body>
</html>
<?php /**PATH D:\web\EdukaVisionNews\resources\views/admin/login.blade.php ENDPATH**/ ?>
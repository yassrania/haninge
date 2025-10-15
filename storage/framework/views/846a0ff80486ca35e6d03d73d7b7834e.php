<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo $__env->yieldContent('title','Haninge Islamiska Forum'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- CSS العام -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/normalize.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/variables.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/layout.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/components.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <?php echo $__env->yieldPushContent('styles'); ?>
  <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>
  <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main>
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- تمهيد CSRF للأجاكس إن احتجته -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (tokenMeta && window.axios) {
        const token = tokenMeta.getAttribute('content');
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      }
    });
  </script>

  <!-- Alpine للواجهة العامة فقط (نسخة واحدة) -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <?php echo $__env->yieldPushContent('scripts'); ?>

  <!-- سكربتاتك -->
  <script defer src="/assets/js/utils.js"></script>
  <script defer src="/assets/js/includes.js"></script>
  <script defer src="/assets/js/main.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Admin\haninge\resources\views/layouts/app.blade.php ENDPATH**/ ?>
<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo $__env->yieldContent('title','Haninge Islamiska Forum'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  
  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


  
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/normalize.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/variables.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/layout.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/components.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">

  
  <?php echo $__env->yieldPushContent('styles'); ?>
  <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>
  <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main>
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
  <script src="<?php echo e(asset('assets/js/utils.js')); ?>" defer></script>
  <script src="<?php echo e(asset('assets/js/includes.js')); ?>" defer></script>
  <script src="<?php echo e(asset('assets/js/main.js')); ?>" defer></script>

  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (tokenMeta) {
        const token = tokenMeta.getAttribute('content');
        window.csrfToken = token;
        if (window.axios) {
          window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }
      }
    });
  </script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


  
  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


  
  <?php echo $__env->yieldPushContent('scripts'); ?>
  <script>
document.addEventListener('livewire:init', () => {
  const meta = document.querySelector('meta[name="csrf-token"]');
  if (meta) {
    Livewire.setHeaders({ 'X-CSRF-TOKEN': meta.getAttribute('content') });
  }
});
</script>

</body>
</html>
<?php /**PATH C:\Users\Admin\haninge\resources\views/layouts/app.blade.php ENDPATH**/ ?>
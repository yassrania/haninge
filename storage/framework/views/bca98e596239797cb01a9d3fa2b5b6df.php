<?php $__env->startSection('title', $service->title ?? 'Tjänst'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $serviceTitle = $service->title ?? \Illuminate\Support\Str::headline(str_replace('-', ' ', $service->slug));
    $serviceSlug  = $service->slug;

    // خرائط صور افتراضية حسب الـ slug (عدّلها كما تريد)
    $images = [
      'boner-och-gudsdyrkan' => 'services/prayer.JPG',
      'islamisk-begravning'  => 'services/funeral.JPG',
      'radgivning'           => 'services/advice.JPG',
      'utbildning'           => 'services/education.JPG',
      'vigsel'               => 'services/wedding.JPG',
    ];
    $img = $images[$serviceSlug] ?? 'goals-1.JPG';
  ?>

  <section class="page container">
    <h1 class="mb-3"><?php echo e($serviceTitle); ?></h1>

    <img src="<?php echo e(asset('assets/img/'.$img)); ?>" alt="<?php echo e($serviceSlug); ?>" style="max-width:100%;height:auto;">

    <div class="mt-4">
      
      <?php if(!empty($service->body)): ?>
        <?php echo $service->body; ?>

      <?php elseif(!empty($service->content)): ?>
        <?php echo $service->content; ?>

      <?php else: ?>
        <p>Detaljer om tjänsten kommer här…</p>
      <?php endif; ?>
    </div>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/service.blade.php ENDPATH**/ ?>
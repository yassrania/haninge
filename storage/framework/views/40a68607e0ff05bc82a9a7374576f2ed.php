<?php $__env->startSection('title', $pageTitle ?? 'Om Islam'); ?>
<?php $__env->startSection('meta_description', $pageDescription ?? 'Haninge Islamiska Forum'); ?>

<?php $__env->startSection('content'); ?>

  
  <?php $banners = $sections->where('type', 'banner'); ?>
  <?php if($banners->count()): ?>
      <?php $b = $banners->first(); ?>
      <section class="page-banner" style="background-image:url('<?php echo e($b->banner_path ? Storage::url($b->banner_path) : '/assets/img/om-islam-banner.jpg'); ?>')">
        <div class="overlay"></div>
        <div class="container banner-inner">
          <h1><?php echo e($b->title ?: 'Om Islam'); ?></h1>
          <?php if($b->subtitle ?? false): ?>
            <p><?php echo e($b->subtitle); ?></p>
          <?php elseif($b->slug ?? false): ?>
            <p><?php echo e($b->slug); ?></p>
          <?php endif; ?>
        </div>
      </section>
  <?php else: ?>
      
      <section class="page-banner" style="background-image:url('/assets/img/om-islam-banner.jpg')">
        <div class="overlay"></div>
        <div class="container banner-inner">
          <h1>Om Islam</h1>
          <p>En introduktion</p>
        </div>
      </section>
  <?php endif; ?>

  <main class="site-main">

    <?php
      // بقية البلوكات غير البنر
      $blocks = $sections->reject(fn($s) => $s->type === 'banner')->values();
    ?>

    <?php $__empty_1 = true; $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

      
    <?php if($block->type === 'image_text'): ?>
  <?php
      $imageHtml = $block->image_path
          ? '<img src="'.e(Storage::url($block->image_path)).'" alt="'.e($block->title).'" />'
          : '';
      $figureClass = 'frame';
      $pos = ($block->image_position === 'right') ? 'right' : 'left';
  ?>

  <section class="section about-grid">
    <div class="container grid-2">

      
      <?php if($pos === 'left'): ?>
        <figure class="<?php echo e($figureClass); ?>"><?php echo $imageHtml; ?></figure>
        <div>
          <?php if($block->title): ?>
            <h2 class="green"><?php echo e($block->title); ?></h2>
          <?php endif; ?>

          <?php if($block->subtitle): ?>
            <h6 class="orange"><?php echo e($block->subtitle); ?></h6>
          <?php endif; ?>

          <?php if($block->content): ?>
            <?php echo $block->content; ?>

          <?php endif; ?>

          <?php if($block->button_url): ?>
            <p><a class="btn-link" href="<?php echo e($block->button_url); ?>"><?php echo e($block->button_label ?: 'Läs mer'); ?></a></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      
      <?php if($pos === 'right'): ?>
        <div>
          <?php if($block->title): ?>
            <h2 class="green"><?php echo e($block->title); ?></h2>
          <?php endif; ?>

          <?php if($block->subtitle): ?>
            <p><?php echo e($block->subtitle); ?></p>
          <?php endif; ?>

          <?php if($block->content): ?>
            <?php echo $block->content; ?>

          <?php endif; ?>

          <?php if($block->button_url): ?>
            <p><a class="btn-link" href="<?php echo e($block->button_url); ?>"><?php echo e($block->button_label ?: 'Läs mer'); ?></a></p>
          <?php endif; ?>
        </div>
        <figure class="<?php echo e($figureClass); ?>"><?php echo $imageHtml; ?></figure>
      <?php endif; ?>

    </div>
  </section>



      
      <?php elseif($block->type === 'text'): ?>
        <?php
          // لو حاب تعمل مقطع أخضر كامل مثل "section-green" في الأصلي:
          // اكتب في Subtitle بالـCMS كلمة section-green (اختياري)
          $isGreen = trim((string)($block->subtitle ?? '')) === 'section-green';
        ?>

        <?php if($isGreen): ?>
          <section class="section about-grid">
    <div class="container grid-2">
              <?php if($block->title): ?><h2 class="white"><?php echo e($block->title); ?></h2><?php endif; ?>
              <?php if($block->content): ?>
                <div class="white"><?php echo $block->content; ?></div>
              <?php endif; ?>
              
            </div>
          </section>
        <?php else: ?>
          <section class="section">
            <div class="container">
              <?php if($block->title): ?><h2 class="green"><?php echo e($block->title); ?></h2><?php endif; ?>
              <?php if($block->subtitle && $block->subtitle !== 'section-green'): ?>
                <p><?php echo e($block->subtitle); ?></p>
              <?php endif; ?>
              <?php if($block->content): ?><?php echo $block->content; ?><?php endif; ?>
            </div>
          </section>
        <?php endif; ?>
      <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      
      <section class="section">
        <div class="container">
          <h2 class="green">Om Islam</h2>
          <p>Innehållet kommer snart.</p>
        </div>
      </section>
    <?php endif; ?>

  </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/om-islam.blade.php ENDPATH**/ ?>
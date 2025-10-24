<?php $__env->startSection('title', $pageTitle ?? 'Om Mosken'); ?>
<?php $__env->startSection('meta_description', $pageDescription ?? 'Haninge Islamiska Forum'); ?>

<?php $__env->startSection('content'); ?>

  
  <?php $banners = $sections->where('type', 'banner'); ?>
  <?php if($banners->count()): ?>
    <?php $b = $banners->first(); ?>
    <section class="page-banner" style="background-image:url('<?php echo e($b->banner_path ? Storage::url($b->banner_path) : '/assets/img/om-mosken-banner.jpg'); ?>')">
      <div class="overlay"></div>
      <div class="container banner-inner">
        <h1><?php echo e($b->title ?: 'Om Mosken'); ?></h1>
        <?php if(!empty($b->subtitle)): ?>
          <p><?php echo e($b->subtitle); ?></p>
        <?php elseif(!empty($b->slug)): ?>
          <p><?php echo e($b->slug); ?></p>
        <?php endif; ?>
      </div>
    </section>
  <?php else: ?>
    <section class="page-banner" style="background-image:url('/assets/img/om-mosken-banner.jpg')">
      <div class="overlay"></div>
      <div class="container banner-inner">
        <h1>Om Mosken</h1>
        <p>Välkommen</p>
      </div>
    </section>
  <?php endif; ?>

  <main class="site-main">
    <?php $blocks = $sections->reject(fn($s) => $s->type === 'banner')->values(); ?>

    
    <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($block->type === 'image_text'): ?>
        <?php
          $imageHtml   = $block->image_path ? '<img src="'.e(Storage::url($block->image_path)).'" alt="'.e($block->title).'" />' : '';
          $figureClass = 'frame';
          $pos         = ($block->image_position === 'right') ? 'right' : 'left';
        ?>

        <section class="section about-grid">
          <div class="container grid-2">
            <?php if($pos === 'left'): ?>
              <figure class="<?php echo e($figureClass); ?>"><?php echo $imageHtml; ?></figure>
              <div>
                <?php if($block->title): ?><h2 class="green"><?php echo e($block->title); ?></h2><?php endif; ?>
                <?php if($block->subtitle): ?><h6 class="orange"><?php echo e($block->subtitle); ?></h6><?php endif; ?>
                <?php if($block->content): ?><?php echo $block->content; ?><?php endif; ?>
                <?php if($block->button_url): ?>
                  <p><a class="btn-link" href="<?php echo e($block->button_url); ?>"><?php echo e($block->button_label ?: 'Läs mer'); ?></a></p>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if($pos === 'right'): ?>
              <div>
                <?php if($block->title): ?><h2 class="green"><?php echo e($block->title); ?></h2><?php endif; ?>
                <?php if($block->subtitle): ?><h6 class="orange"><?php echo e($block->subtitle); ?></h6><?php endif; ?>
                <?php if($block->content): ?><?php echo $block->content; ?><?php endif; ?>
                <?php if($block->button_url): ?>
                  <p><a class="btn-link" href="<?php echo e($block->button_url); ?>"><?php echo e($block->button_label ?: 'Läs mer'); ?></a></p>
                <?php endif; ?>
              </div>
              <figure class="<?php echo e($figureClass); ?>"><?php echo $imageHtml; ?></figure>
            <?php endif; ?>
          </div>
        </section>
      <?php elseif($block->type === 'text'): ?>
        <section class="section">
          <div class="container">
            <?php if($block->title): ?><h2 class="green"><?php echo e($block->title); ?></h2><?php endif; ?>
            <?php if($block->subtitle): ?><p><?php echo e($block->subtitle); ?></p><?php endif; ?>
            <?php if($block->content): ?><?php echo $block->content; ?><?php endif; ?>
          </div>
        </section>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($hasDonate): ?>
      <section class="donate-card">
        <div class="container">
          <div class="donate-box">
            <figure class="donate-qr">
              <?php if($qrImg): ?>
                <img src="<?php echo e($qrImg); ?>" alt="Swish – Stöd moskén">
              <?php endif; ?>
            </figure>
            <div class="donate-text">
              <?php if($dTitle): ?>  <h2 class="green"><?php echo e($dTitle); ?></h2> <?php endif; ?>
              <?php if($dSub): ?>    <h5 class="deep"><?php echo e($dSub); ?></h5>   <?php endif; ?>
              <?php if($dBody): ?>   <div class="text"><?php echo $dBody; ?></div> <?php endif; ?>
              <?php if($dBtnTxt && $dBtnUrl): ?>
                <a href="<?php echo e($dBtnUrl); ?>" class="btn-orange"><?php echo e($dBtnTxt); ?></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

  </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/om-mosken.blade.php ENDPATH**/ ?>
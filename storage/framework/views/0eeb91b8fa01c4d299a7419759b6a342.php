<?php
    use App\Models\ServicesPageSetting;

    $s = ServicesPageSetting::first();

    // Banner
    $banner = $s?->banner ? asset('storage/'.$s->banner) : asset('assets/img/om-islam-banner.jpg');
    $title  = $s?->title ?? 'Våra tjänster';
    $sub    = $s?->subtitle ?? null;

    // Kort
    $cardsTitle = $s?->cards_section_title ?? null;
    $cardsSub   = $s?->cards_section_subtitle ?? null;
    $cardsDesc  = $s?->cards_section_description ?? null;
    $cards      = (array) ($s?->cards ?? []);

    // Utbildning
    $eduTitle = $s?->education_title ?? null;
    $eduSub   = $s?->education_subtitle ?? null;
    $eduDesc  = $s?->education_description ?? null;
    $edu      = (array) ($s?->education_items ?? []);
?>


<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>


<section class="page-banner" style="background-image:url('<?php echo e($banner); ?>')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1><?php echo e($title); ?></h1>
    <?php if($sub): ?><p><?php echo e($sub); ?></p><?php endif; ?>
  </div>
</section>

<main>

  
  <?php if($cardsTitle || $cardsSub || $cardsDesc || count($cards)): ?>
  <section class="section">
    <div class="container">
      <?php if($cardsTitle): ?><h2 class="section-title"><?php echo e($cardsTitle); ?></h2><?php endif; ?>
      <?php if($cardsSub): ?><h6 class="orange"><?php echo e($cardsSub); ?></h6><?php endif; ?>
      <?php if($cardsDesc): ?><div class="text"><?php echo $cardsDesc; ?></div><?php endif; ?>

      <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $img   = !empty($c['image']) ? asset('storage/'.$c['image']) : null;
          $posRaw= strtolower(trim($c['image_position'] ?? 'left'));
          // دعم كتابات متعددة لليمين
          $pos   = in_array($posRaw, ['right','höger','hoger']) ? 'right' : 'left';
        ?>

        <div class="prayer-grid <?php echo e($pos === 'right' ? 'img-right' : 'img-left'); ?>" style="margin-bottom:28px">
          <figure class="prayer-frame frame">
            <?php if($img): ?><img src="<?php echo e($img); ?>" alt="<?php echo e($c['title'] ?? ''); ?>"><?php endif; ?>
          </figure>

          <div class="prayer-text">
            <?php if(!empty($c['title'])): ?>    <h2 class="green"><?php echo e($c['title']); ?></h2><?php endif; ?>
            <?php if(!empty($c['subtitle'])): ?> <h6 class="orange"><?php echo e($c['subtitle']); ?></h6><?php endif; ?>
            <?php if(!empty($c['body'])): ?>     <div class="text"><?php echo $c['body']; ?></div><?php endif; ?>
            <?php if(!empty($c['button_text']) && !empty($c['button_url'])): ?>
              <a class="btn-orange" href="<?php echo e($c['button_url']); ?>"><?php echo e($c['button_text']); ?></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>

  
  <section class="prayer-band" aria-hidden="true"></section>
  <?php endif; ?>

  
  <?php if($eduTitle || $eduSub || $eduDesc || count($edu)): ?>
  <section class="section">
    <div class="container">
      <?php if($eduTitle): ?><h2 class="section-title"><?php echo e($eduTitle); ?></h2><?php endif; ?>
      <?php if($eduSub): ?>  <h6 class="orange"><?php echo e($eduSub); ?></h6><?php endif; ?>
      <?php if($eduDesc): ?> <div class="text"><?php echo $eduDesc; ?></div><?php endif; ?>

      <?php $__currentLoopData = $edu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $eImg = !empty($e['image']) ? asset('storage/'.$e['image']) : null;
          $ePos = in_array(strtolower(trim($e['image_position'] ?? 'left')), ['right','höger','hoger']) ? 'right' : 'left';
        ?>

        <div class="prayer-grid <?php echo e($ePos === 'right' ? 'img-right' : 'img-left'); ?>" style="margin-bottom:28px">
          <figure class="prayer-frame frame">
            <?php if($eImg): ?><img src="<?php echo e($eImg); ?>" alt="<?php echo e($e['title'] ?? ''); ?>"><?php endif; ?>
          </figure>

          <div class="prayer-text">
            <?php if(!empty($e['title'])): ?>    <h3 class="green"><?php echo e($e['title']); ?></h3><?php endif; ?>
            <?php if(!empty($e['subtitle'])): ?> <h6 class="orange"><?php echo e($e['subtitle']); ?></h6><?php endif; ?>
            <?php if(!empty($e['body'])): ?>     <div class="text"><?php echo $e['body']; ?></div><?php endif; ?>
            <?php if(!empty($e['button_text']) && !empty($e['button_url'])): ?>
              <a class="btn-orange" href="<?php echo e($e['button_url']); ?>"><?php echo e($e['button_text']); ?></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
  <?php endif; ?>

</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/tjanster.blade.php ENDPATH**/ ?>
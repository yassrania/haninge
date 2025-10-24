
<?php $__env->startSection('title', $archive->title); ?>

<?php $__env->startSection('content'); ?>
<style>
  /* يمنع أي تمرير أفقي */
  body { overflow-x: hidden; }

  /* اكسر الكلمات الطويلة داخل المحتوى */
  .archive-content { white-space: normal; word-break: break-word; overflow-wrap: anywhere; }

  /* صور المعرض */
  .archive-gallery img {
    width: 100%; height: 220px; object-fit: cover;
    border-radius: .5rem; display: block;
  }
  @media (min-width: 992px) {
    .archive-gallery img { height: 260px; }
  }
</style>

<div class="container py-4">
  <div class="mb-2">
    <a href="<?php echo e(route('arkiv.index')); ?>" class="btn btn-sm btn-outline-secondary">&larr; Tillbaka</a>
  </div>

  <h1 class="mb-1"><?php echo e($archive->title); ?></h1>
  <?php if($archive->event_date): ?>
    <div class="text-muted mb-3"><?php echo e($archive->event_date->format('Y-m-d')); ?></div>
  <?php endif; ?>

  
  <?php if(is_array($archive->images) && count($archive->images)): ?>
    <div class="row g-3 mb-4 archive-gallery">
      <?php $__currentLoopData = $archive->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-4 col-lg-3">
          <a href="<?php echo e(asset('storage/'.$img)); ?>" target="_blank" rel="noopener">
            <img src="<?php echo e(asset('storage/'.$img)); ?>" alt="">
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>

  
  <?php if($archive->body): ?>
    <div class="archive-content"><?php echo $archive->body; ?></div>
  <?php elseif($archive->excerpt): ?>
    <p class="text-muted archive-content"><?php echo e($archive->excerpt); ?></p>
  <?php else: ?>
    <p class="text-muted">Ingen text.</p>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/arkiv-show.blade.php ENDPATH**/ ?>
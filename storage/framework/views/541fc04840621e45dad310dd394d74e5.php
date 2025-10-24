
<?php $__env->startSection('title','Arkiv'); ?>

<?php $__env->startSection('content'); ?>
<style>
  /* يمنع أي تمدد أفقي */
  body { overflow-x: hidden; }

  /* الكارت */
  .archive-card { overflow: hidden; }
  .archive-title { margin: 0; }

  /* النصوص: اكسر الكلمات الطويلة */
  .archive-text { white-space: normal; word-break: break-word; overflow-wrap: anywhere; }

  /* صورة المصغّر */
  .archive-thumb {
    width: 160px; height: 120px;
    object-fit: cover; border-radius: .5rem;
    display: block;
  }

  /* اجعل رابط العنصر display:block ليتصرف ككارت من دون تمدد */
  .archive-link { display: block; }
</style>

<div class="container py-4">
  <h1 class="mb-3">Arkiv</h1>

  <?php if($archives->isEmpty()): ?>
    <p class="text-muted">Inga poster ännu.</p>
  <?php else: ?>
    <div class="list-group">
      <?php $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="list-group-item list-group-item-action archive-card archive-link" href="<?php echo e(route('arkiv.show', $a->slug)); ?>">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="archive-title"><?php echo e($a->title); ?></h5>
            <?php if($a->event_date): ?>
              <small><?php echo e($a->event_date->format('Y-m-d')); ?></small>
            <?php endif; ?>
          </div>

          <?php if($a->excerpt): ?>
            <p class="mb-2 text-muted archive-text">
              <?php echo e(\Illuminate\Support\Str::limit(strip_tags($a->excerpt), 200)); ?>

            </p>
          <?php endif; ?>

          <?php $first = is_array($a->images) && count($a->images) ? $a->images[0] : null; ?>
          <?php if($first): ?>
            <img src="<?php echo e(asset('storage/'.$first)); ?>" alt="" class="archive-thumb mt-1">
          <?php endif; ?>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-3">
      <?php echo e($archives->links()); ?>

    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/arkiv.blade.php ENDPATH**/ ?>
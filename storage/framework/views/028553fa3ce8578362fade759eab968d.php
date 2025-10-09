

<?php $__env->startSection('title', $pageTitle ?? $nyhet->title); ?>
<?php $__env->startSection('meta_description', $pageDescription ?? ''); ?>

<?php $__env->startSection('content'); ?>

  
  

  <main class="site-main">
    <section class="section">
      <div class="container">
        <article class="news-article">
          <?php if($nyhet->image_path): ?>
            <figure class="news-figure">
              <img src="<?php echo e(Storage::url($nyhet->image_path)); ?>" alt="<?php echo e($nyhet->title); ?>">
            </figure>
          <?php endif; ?>

          <?php if($nyhet->excerpt): ?>
            <p class="lead"><?php echo e($nyhet->excerpt); ?></p>
          <?php endif; ?>

          <?php if($nyhet->body): ?>
            <div class="prose"><?php echo $nyhet->body; ?></div>
          <?php endif; ?>
        </article>
      </div>
    </section>
  </main>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.news-figure img{ width:100%; height:auto; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); margin-bottom:16px; }
.lead{ font-size:18px; color:#444; margin-bottom:16px; }
.prose p{ line-height:1.8; margin:0 0 1em; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/news/show.blade.php ENDPATH**/ ?>
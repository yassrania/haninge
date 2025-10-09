<?php $__env->startSection('title', $pageTitle ?? 'Nyheter — Haninge Islamiska Forum'); ?>
<?php $__env->startSection('meta_description', $pageDescription ?? ''); ?>

<?php $__env->startSection('content'); ?>

  
  <section class="page-banner" style="background-image:url('<?php echo e($banner?->banner_path ? Storage::url($banner->banner_path) : asset('assets/img/nyheter-banner.jpg')); ?>')">
    <div class="overlay"></div>
    <div class="container banner-inner">
      <h1><?php echo e($banner->title ?? 'Nyheter'); ?></h1>
      <?php if(!empty($banner?->subtitle)): ?>
        <p><?php echo e($banner->subtitle); ?></p>
      <?php endif; ?>
    </div>
  </section>

  
  <main class="site-main">
    <section class="section">
      <div class="container">
        <div class="news-grid">
          <?php $__empty_1 = true; $__currentLoopData = $nyheter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="news-card">
              <a href="<?php echo e(route('nyheter.show', $item->slug)); ?>" class="news-thumb">
                <?php if($item->image_path): ?>
                  <img src="<?php echo e(Storage::url($item->image_path)); ?>" alt="<?php echo e($item->title); ?>">
                <?php endif; ?>
              </a>

              <div class="news-body">
                <h3 class="news-title">
                  <a href="<?php echo e(route('nyheter.show', $item->slug)); ?>"><?php echo e($item->title); ?></a>
                </h3>

                <?php if($item->excerpt): ?>
                  <p class="news-excerpt"><?php echo e($item->excerpt); ?></p>
                <?php endif; ?>

                <p class="news-more">
                  <a href="<?php echo e(route('nyheter.show', $item->slug)); ?>" class="btn-link">Läs mer »</a>
                </p>
              </div>

              <div class="news-meta">
                <?php if($item->published_at): ?>
                  <span><?php echo e($item->published_at->format('Y-m-d')); ?></span>
                  <span>•</span>
                  <span><?php echo e($item->published_at->format('H:i:s')); ?></span>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-gray-500">Inga nyheter ännu.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.news-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
@media(max-width:1100px){ .news-grid{ grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px){ .news-grid{ grid-template-columns:1fr;} }

.news-card{ background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); overflow:hidden; display:flex; flex-direction:column; }
.news-thumb img{ width:100%; height:220px; object-fit:cover; display:block; }
.news-body{ padding:20px; }
.news-title{ font-size:28px; margin:0 0 8px; }
.news-excerpt{ color:#555; line-height:1.6; }
.news-more{ margin-top:12px; }
.news-meta{ padding:14px 20px; color:#888; font-size:14px; border-top:1px solid #eee; margin-top:auto; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/nyheter.blade.php ENDPATH**/ ?>
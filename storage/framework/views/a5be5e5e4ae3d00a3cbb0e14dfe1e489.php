
<?php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route;

    // عناصر المستوى الأول + الأولاد
    $tops = Menu::whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('order')
        ->with(['children' => fn($q) => $q->where('is_active', true)->orderBy('order')])
        ->get();

    // دالة ترجّع الرابط الصحيح (route إذا كاين وإلا url)
    $urlFor = function ($item) {
        if ($item->route && Route::has($item->route)) {
            return route($item->route);
        }
        return $item->url ?: 'javascript:void(0)';
    };

    // active helper
    $isActive = function ($item) {
        return $item->route && Route::has($item->route) && request()->routeIs($item->route);
    };
?>

<header class="site-header border-bottom">
  <div class="container py-2">
    <div class="row align-items-center g-3 flex-nowrap flex-md-wrap">

      
      <div class="col-auto order-1 order-md-1">
        <a href="<?php echo e(url('/')); ?>" class="d-inline-flex align-items-center text-decoration-none">
          <?php if($site?->logo): ?>
            <img src="<?php echo e(Storage::url($site->logo)); ?>"
                 alt="<?php echo e($site->site_name ?? 'Logo'); ?>"
                 class="site-logo">
          <?php else: ?>
            <span class="fw-bold fs-4 text-dark"><?php echo e($site->site_name ?? 'Haninge Islamiska Forum'); ?></span>
          <?php endif; ?>
        </a>
      </div>

      
      <div class="col order-3 order-md-2">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-md-center gap-3 contact-wrap">

          <?php if($site?->phone): ?>
            <a class="d-inline-flex align-items-center text-decoration-none text-dark"
               href="tel:<?php echo e(preg_replace('/\s+/', '', $site->phone)); ?>">
              <i class="fa fa-phone me-2"></i>
              <span class="small fw-semibold"><?php echo e($site->phone); ?></span>
            </a>
          <?php endif; ?>

          <?php if($site?->email): ?>
            <a class="d-inline-flex align-items-center text-decoration-none text-dark"
               href="mailto:<?php echo e($site->email); ?>">
              <i class="fa fa-envelope me-2"></i>
              <span class="small fw-semibold"><?php echo e($site->email); ?></span>
            </a>
          <?php endif; ?>

        </div>
      </div>

      
      <div class="col-auto order-2 order-md-3 ms-auto">
        <?php if(is_array($site?->social)): ?>
          <div class="d-flex align-items-center gap-3">
            <?php $__currentLoopData = $site->social; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $network => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(!empty($url)): ?>
                <a href="<?php echo e($url); ?>" target="_blank" rel="noopener"
                   class="text-dark social-link" title="<?php echo e(ucfirst($network)); ?>">
                  <i class="fab fa-<?php echo e(strtolower($network)); ?>"></i>
                </a>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</header>
<?php /**PATH C:\Users\Admin\haninge\resources\views/partials/header.blade.php ENDPATH**/ ?>
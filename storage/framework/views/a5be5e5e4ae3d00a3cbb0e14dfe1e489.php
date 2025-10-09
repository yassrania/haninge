
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

<header class="site-header">
  <div class="container header-inner">
    <a class="logo" href="<?php echo e(route('home')); ?>">
      <img src="<?php echo e(asset('assets/img/logo.svg')); ?>" alt="Haninge Islamiska Forum" />
    </a>

    <nav class="nav" aria-label="Huvudnavigation">
      <button class="nav-toggle" aria-controls="site-menu" aria-expanded="false">
        <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        <span class="sr-only">Meny</span>
      </button>

      <ul id="site-menu" class="menu">
        <?php $__currentLoopData = $tops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($item->children->count()): ?>
            <li class="has-submenu <?php echo e($item->children->contains(fn($c) => $isActive($c)) ? 'open' : ''); ?>">
              <a href="<?php echo e($urlFor($item)); ?>"
                 class="submenu-toggle"
                 aria-haspopup="true"
                 aria-expanded="<?php echo e($item->children->contains(fn($c) => $isActive($c)) ? 'true' : 'false'); ?>">
                <?php echo e($item->label); ?>

              </a>

              <ul class="submenu" aria-label="Undermeny — <?php echo e($item->label); ?>">
                <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a href="<?php echo e($urlFor($child)); ?>"
                       <?php if($child->new_tab): ?> target="_blank" rel="noopener" <?php endif; ?>
                       class="<?php echo e($child->type === 'cta' ? 'btn btn-small btn-orange' : ''); ?> <?php echo e($isActive($child) ? 'is-active' : ''); ?>">
                      <?php echo e($child->label); ?>

                    </a>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </li>
          <?php else: ?>
            <li>
              <a href="<?php echo e($urlFor($item)); ?>"
                 <?php if($item->new_tab): ?> target="_blank" rel="noopener" <?php endif; ?>
                 class="<?php echo e($item->type === 'cta' ? 'btn btn-small btn-orange' : ''); ?> <?php echo e($isActive($item) ? 'is-active' : ''); ?>">
                <?php echo e($item->label); ?>

              </a>
            </li>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </nav>
  </div>

  
  <script>
    (function(){
      const qs=(s,c=document)=>c.querySelector(s);
      const qsa=(s,c=document)=>Array.from(c.querySelectorAll(s));
      const navToggle = qs('.nav-toggle');
      const menu = qs('#site-menu');

      if(navToggle && menu){
        navToggle.addEventListener('click', ()=>{
          const open = menu.classList.toggle('open');
          navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
      }
      qsa('.has-submenu').forEach(li=>{
        const toggle = qs('.submenu-toggle', li);
        li.addEventListener('mouseenter', ()=>{ if (innerWidth>980){ li.classList.add('open'); toggle?.setAttribute('aria-expanded','true'); }});
        li.addEventListener('mouseleave', ()=>{ if (innerWidth>980){ li.classList.remove('open'); toggle?.setAttribute('aria-expanded','false'); }});
        toggle && toggle.addEventListener('click', (e)=>{
          if(innerWidth<=980){ e.preventDefault(); const isOpen = li.classList.toggle('open'); toggle.setAttribute('aria-expanded', isOpen?'true':'false'); }
        });
      });
    })();
  </script>
</header>
<?php /**PATH C:\Users\Admin\haninge\resources\views/partials/header.blade.php ENDPATH**/ ?>
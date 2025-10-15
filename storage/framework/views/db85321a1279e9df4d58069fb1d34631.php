<?php
  $footer = $footer ?? \App\Models\FooterSetting::first();
  $footerGroups = $footerGroups ?? \App\Models\FooterLinkGroup::with('links')->get();
  $servicesGroup = $footerGroups->firstWhere('name', 'Våra tjänster') ?? $footerGroups->first();

  $site = $site ?? \App\Models\Setting::first();
  $social = is_array($site?->social) ? $site->social : [];
?>

<footer class="site-footer">
  <div class="container footer-grid">
    <div class="foot-col">
      <?php if($footer?->logo): ?>
        <img src="<?php echo e(Storage::disk('public')->url($footer->logo)); ?>" alt="Logo" class="foot-logo">
      <?php endif; ?>
    </div>

    <div class="foot-col">
      <h3 class="foot-title">Våra tjänster</h3>
      <?php if($servicesGroup && $servicesGroup->links && $servicesGroup->links->count()): ?>
        <ul class="foot-links">
          <?php $__currentLoopData = $servicesGroup->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lnk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e($lnk->url); ?>"><?php echo e($lnk->title); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      <?php else: ?>
        <p class="muted">Inga länkar.</p>
      <?php endif; ?>
    </div>

    <div class="foot-col">
      
      <?php $today = \App\Models\PrayerTime::whereDate('date', today())->first(); ?>
      <?php echo $__env->make('partials.prayer-today', ['today' => $today, 'title' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="foot-col">
      <h3 class="foot-title">Kontaktuppgifter</h3>

      <?php if($footer?->address): ?>
        <p class="foot-line"><i class="fa-solid fa-location-dot"></i> <?php echo e($footer->address); ?></p>
      <?php endif; ?>
      <?php if($footer?->phone): ?>
        <p class="foot-line"><i class="fa-solid fa-phone"></i>
          <a href="tel:<?php echo e(preg_replace('/\s+/', '', $footer->phone)); ?>"><?php echo e($footer->phone); ?></a></p>
      <?php endif; ?>
      <?php if($footer?->email): ?>
        <p class="foot-line"><i class="fa-solid fa-envelope"></i>
          <a href="mailto:<?php echo e($footer->email); ?>"><?php echo e($footer->email); ?></a></p>
      <?php endif; ?>
      <?php if($footer?->bankgiro): ?>
        <p class="foot-line"><i class="fa-solid fa-coins"></i> Bankgiro: <?php echo e($footer->bankgiro); ?></p>
      <?php endif; ?>
      <?php if(!empty($footer?->swish_number)): ?>
     <p class="foot-line"><strong><i class="fa-solid fa-coins"></i>Swish:</strong> <?php echo e($footer->swish_number); ?></p>
     <?php endif; ?>

      <?php if(!empty($social)): ?>
      <div class="foot-social">
        <?php $__currentLoopData = $social; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $net => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(empty($url)) continue; ?>
          <a class="foot-social-btn"
             href="<?php echo e(\Illuminate\Support\Str::startsWith($url, ['http://','https://']) ? $url : 'https://'.$url); ?>"
             target="_blank" rel="noopener" aria-label="<?php echo e(ucfirst($net)); ?>">
            <i class="fa-brands fa-<?php echo e(strtolower($net)); ?>"></i>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php endif; ?>
    </div>

  </div>
</footer>

<style>
.site-footer{ background:#2B9E3C; color:#fff; padding:48px 0; }
.footer-grid{ display:grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap:32px; }
@media (max-width:1100px){ .footer-grid{ grid-template-columns: 1fr 1fr; } }
@media (max-width:700px){ .footer-grid{ grid-template-columns: 1fr; } }
.foot-col{ min-width:0; }
.foot-logo{ max-width: 220px; height:auto; display:block; }
.foot-title{ margin:0 0 12px; font-size:28px; font-weight:800; }
.foot-links{ list-style:none; margin:0; padding:0; }
.foot-links li{ margin:8px 0; }
.foot-links a{ color:#fff; text-decoration:none; }
.foot-links a:hover{ text-decoration:underline; }
.foot-line{ display:flex; gap:10px; align-items:flex-start; margin:10px 0; }
.foot-line a{ color:#fff; text-decoration:none; }
.foot-line i{ width:18px; line-height:1.2; margin-top:2px; }
.foot-social{ display:flex; gap:12px; margin-top:12px; }
.foot-social-btn{ width:40px; height:40px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; background:rgba(255,255,255,.15); color:#fff; }
.foot-social-btn:hover{ background:rgba(255,255,255,.25); }
</style>
<?php /**PATH C:\Users\Admin\haninge\resources\views/partials/footer.blade.php ENDPATH**/ ?>
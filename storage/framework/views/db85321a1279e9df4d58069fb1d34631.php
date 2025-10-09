
<?php
    use App\Models\FooterSetting;
    use App\Models\FooterLinkGroup;
    $footer = FooterSetting::first();
    $groups = FooterLinkGroup::with('links')->orderBy('sort')->get();
?>

<footer id="contact" class="site-footer">
 <div class="footer-skyline" aria-hidden="true"></div>


  
  <div class="container footer-inner">
    <div class="footer-brand">
      <?php if($footer?->brand_logo): ?>
        <img src="<?php echo e(asset('storage/'.$footer->brand_logo)); ?>" alt="<?php echo e($footer->brand_alt); ?>" />
      <?php endif; ?>
      <?php if($footer?->brand_text): ?>
        <p><?php echo e($footer->brand_text); ?></p>
      <?php endif; ?>
    </div>

    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="footer-col">
        <h4><?php echo e($group->title); ?></h4>
        <ul>
          <?php $__currentLoopData = $group->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <a href="<?php echo e($link->url); ?>" <?php if($link->is_external): ?> target="_blank" rel="noopener" <?php endif; ?>><?php echo e($link->label); ?></a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!--<div class="footer-col">
      <h4>Öppettider</h4>
      <ul>
        <?php $__currentLoopData = ($footer->opening_hours ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($row['label'] ?? ''); ?>: <?php echo e($row['value'] ?? ''); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
//-->
    <div class="footer-col">
      <h4>Kontaktuppgifter</h4>
      <ul class="contact-list">
        <?php if($footer?->address): ?><li>Adress: <?php echo e($footer->address); ?></li><?php endif; ?>
        <?php if($footer?->phone): ?><li>Telefon: <?php echo e($footer->phone); ?></li><?php endif; ?>
        <?php if($footer?->email): ?><li>E-post: <?php echo e($footer->email); ?></li><?php endif; ?>
      </ul>
      <?php if(!empty($footer?->social_links)): ?>
        <div class="socials">
          <?php $__currentLoopData = $footer->social_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($s['url'] ?? '#'); ?>" target="_blank" rel="noopener"><?php echo e($s['platform'] ?? 'Social'); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <p><?php echo e($footer->bottom_text ?? ('© '.date('Y').' Haninge Islamiska Forum. Alla rättigheter förbehållna.')); ?></p>
    </div>
  </div>
</footer>
<?php /**PATH C:\Users\Admin\haninge\resources\views/partials/footer.blade.php ENDPATH**/ ?>
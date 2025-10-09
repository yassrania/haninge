


<?php $__env->startSection('title', ($service->title ?? 'Tjänst') . ' — Haninge Islamiska Forum'); ?>

<?php $__env->startSection('content'); ?>

<?php
    // Banner
    $banner = $service->page_banner
        ? asset('storage/'.$service->page_banner)
        : asset('assets/img/om-islam-banner.jpg');

    // Builder blocks (Innehåll)
    $blocks = is_array($service->blocks ?? null) ? $service->blocks : [];
    $formFields = is_array($service->form_fields ?? null) ? $service->form_fields : [];


    // Fallback: Prayer fields (لو ما فيه blocks)
    $prImg      = $service->prayer_image    ? asset('storage/'.$service->prayer_image) : null;
    $prTitle    = $service->prayer_title    ?? null;
    $prSubtitle = $service->prayer_subtitle ?? null;
    $prArticle  = $service->prayer_article  ?? null;

    // Donera (لا تظهر إلا عند وجود بيانات)
    $qrImg   = $service->donate_qr_image ? asset('storage/'.$service->donate_qr_image) : null;
    $dTitle  = $service->donate_title    ?? null;
    $dSub    = $service->donate_subtitle ?? null;
    $dBody   = $service->donate_article  ?? null;
    $dBtnTxt = $service->donate_btn_text ?? null;
    $dBtnUrl = $service->donate_btn_url  ?? null;

    $hasDonate = $qrImg || $dTitle || $dSub || $dBody || ($dBtnTxt && $dBtnUrl);
?>

<!-- ===== Banner (نفس الكلاسات) ===== -->
<section class="page-banner" style="background-image:url('<?php echo e($banner); ?>')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1><?php echo e($service->title ?? 'Tjänst'); ?></h1>
    <?php if(!empty($service->subtitle)): ?>
      <p><?php echo e($service->subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>

<main>

  
  <?php if(count($blocks)): ?>
    <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $type = $block['type'] ?? null;
        $data = $block['data'] ?? [];
      ?>

      
      <?php if($type === 'section_title'): ?>
        <section class="section">
          <div class="container prayer-grid">
            <div class="prayer-text">
            <?php if(!empty($data['title'])): ?>    <h2 class="green"><?php echo e($data['title']); ?></h2> <?php endif; ?>
            <?php if(!empty($data['subtitle'])): ?> <h6 class="orange"><?php echo e($data['subtitle']); ?></h6> <?php endif; ?>
          </div>
        </section>
      <?php endif; ?>

      
      <?php if($type === 'rich_text'): ?>
        <section class="section">
          <div class="container">
            <p> class="text"><?php echo $data['content'] ?? ''; ?></p>
</div>
          </div>
        </section>
      <?php endif; ?>

      
      <?php if($type === 'image_with_text'): ?>
  <?php
    $img = !empty($data['image']) ? asset('storage/'.$data['image']) : null;

    $posRaw = strtolower(trim($data['image_position'] ?? 'left'));
    // ندعم كتابات متعددة:
    $pos = in_array($posRaw, ['right','höger','hoger']) ? 'right' : 'left';
  ?>
         <section class="section">
    <div class="container prayer-grid <?php echo e($pos === 'right' ? 'img-right' : 'img-left'); ?>">
      <figure class="prayer-frame frame">
        <?php if($img): ?>
          <img src="<?php echo e($img); ?>" alt="<?php echo e($data['title'] ?? ''); ?>">
        <?php endif; ?>
      </figure>

      <div class="prayer-text">
        <?php if(!empty($data['title'])): ?> <h2 class="green"><?php echo e($data['title']); ?></h2> <?php endif; ?>
        <?php if(!empty($data['text'])): ?>  <div class="text"><?php echo nl2br(e($data['text'])); ?></div> <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  
  <?php elseif($prImg || $prTitle || $prSubtitle || $prArticle): ?>
    <section class="section">
      <div class="container prayer-grid">
        <figure class="prayer-frame frame">
          <?php if($prImg): ?>
            <img src="<?php echo e($prImg); ?>" alt="<?php echo e($prTitle ?? 'Bön i moskén'); ?>">
          <?php endif; ?>
        </figure>
        <div class="prayer-text">
          <?php if($prTitle): ?>    <h2 class="green"><?php echo e($prTitle); ?></h2>      <?php endif; ?>
          <?php if($prSubtitle): ?> <h6 class="orange"><?php echo e($prSubtitle); ?></h6>  <?php endif; ?>
          <?php if($prArticle): ?>  <div class="text"><?php echo $prArticle; ?></div> <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
<!-- ===== Form (نفس الكلاسات) ===== -->
<?php if(count($formFields)): ?>
<section class="vigsel-wrap">
  <div class="vigsel-card">
    <h2 class="vigsel-title"><?php echo e($service->form_title ?? ($service->title.' – Formulär')); ?></h2>

    <?php
      // تجميع حسب المجموعة (الخطوة)، مع ترتيب داخلي
      $groups = collect($formFields)
        ->sortBy(fn($f) => $f['order'] ?? 0)
        ->groupBy(fn($f) => trim($f['group'] ?? 'Steg'));
      $groupLabels = $groups->keys()->values()->all();
    ?>

    
    <ol class="vigsel-steps" role="tablist" aria-label="Steg">
      <?php $__currentLoopData = $groupLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($i===0 ? 'is-active' : ''); ?>" data-step="<?php echo e($i+1); ?>">
          <span class="pill"><?php echo e($i+1); ?></span>
          <span class="lbl"><?php echo e(strtoupper($g)); ?></span>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>

    
    <form id="dynWizardForm" action="<?php echo e(route('service.form.submit', $service->slug)); ?>" method="post" enctype="multipart/form-data" novalidate>
      <?php echo csrf_field(); ?>

      <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <fieldset class="wizard-step" data-step="<?php echo e($loop->iteration); ?>" aria-hidden="<?php echo e($loop->first ? 'false' : 'true'); ?>" style="<?php echo e($loop->first ? '' : 'display:none'); ?>">
          <legend><?php echo e($idx); ?></legend>

          
          <div class="wizard-grid">
          <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $type  = $f['type'] ?? 'text';
              $name  = $f['name'] ?? ('field_'.uniqid());
              $label = $f['label'] ?? ucfirst($name);
              $req   = !empty($f['required']);
              $ph    = $f['placeholder'] ?? '';
              $help  = $f['help'] ?? '';
              $opts  = array_filter(array_map('trim', explode(',', $f['options'] ?? '')));
              $w     = $f['width'] ?? '1/3';
              $wCls  = $w==='1' ? 'col-1' : ($w==='1/2' ? 'col-1-2' : 'col-1-3');
            ?>
               <?php if($type === 'description'): ?>
    <div class="frow col-1">
      <div class="form-description">
        <?php echo $f['content'] ?? ''; ?>

      </div>
    </div>
    <?php continue; ?>
  <?php endif; ?>
            <div class="frow <?php echo e($wCls); ?>">
              
              <?php if($type === 'checkbox'): ?>
                <label class="checkbox">
                  <input type="checkbox" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="1" <?php echo e(old($name) ? 'checked' : ''); ?> <?php echo e($req ? 'required' : ''); ?>>
                  <span><?php echo e($label); ?> <?php if($req): ?><span class="req">*</span><?php endif; ?></span>
                </label>
                <?php if($help): ?><small class="help"><?php echo e($help); ?></small><?php endif; ?>
                <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <?php else: ?>
                <label for="<?php echo e($name); ?>"><?php echo e($label); ?> <?php if($req): ?><span class="req">*</span><?php endif; ?></label>

                <?php if($type === 'textarea'): ?>
                  <textarea id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" rows="4" placeholder="<?php echo e($ph); ?>" <?php echo e($req ? 'required' : ''); ?>><?php echo e(old($name)); ?></textarea>

                <?php elseif($type === 'select'): ?>
                  <select id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" <?php echo e($req ? 'required' : ''); ?>>
                    <option value="" disabled selected><?php echo e($ph ?: 'Välj…'); ?></option>
                    <?php $__currentLoopData = $opts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($op); ?>"><?php echo e($op); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>

                <?php elseif($type === 'file'): ?>
                  <input type="file" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" <?php echo e($req ? 'required' : ''); ?>>

                <?php else: ?>
                  
                  <input type="<?php echo e(in_array($type,['text','email','tel','date','time']) ? $type : 'text'); ?>"
                         id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($name)); ?>"
                         placeholder="<?php echo e($ph); ?>" <?php echo e($req ? 'required' : ''); ?>>
                <?php endif; ?>

                <?php if($help): ?><small class="help"><?php echo e($help); ?></small><?php endif; ?>
                <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="wizard-actions <?php echo e($loop->first ? '' : ($loop->last ? 'between' : 'between')); ?>">
            <?php if(!$loop->first): ?>
              <button type="button" class="btn-prev">Tillbaka</button>
            <?php endif; ?>
            <?php if(!$loop->last): ?>
              <button type="button" class="btn-next">Nästa</button>
            <?php else: ?>
              <button type="submit" class="btn-submit">Skicka</button>
            <?php endif; ?>
          </div>
        </fieldset>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <script>
document.getElementById('dynWizardForm')?.addEventListener('submit', function () {
  this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
});
</script>

    </form>
  </div>
</section>
<script>
(function(){
  const form  = document.getElementById('dynWizardForm');
  if(!form) return;
  const steps = Array.from(document.querySelectorAll('.wizard-step'));
  const tabs  = Array.from(document.querySelectorAll('.vigsel-steps li'));
  let idx = 0;

  function show(i){
    steps.forEach((s,k)=>{
      const on = k===i;
      s.style.display = on ? '' : 'none';
      s.setAttribute('aria-hidden', on ? 'false' : 'true');
    });
    tabs.forEach((t,k)=> t.classList.toggle('is-active', k===i));
    idx = i;
    window.scrollTo({ top: form.closest('.vigsel-wrap').offsetTop - 40, behavior: 'smooth' });
  }
  function next(){ if(idx < steps.length-1) show(idx+1); }
  function prev(){ if(idx > 0) show(idx-1); }

  form.addEventListener('click', (e)=>{
    if(e.target.matches('.btn-next')){ e.preventDefault(); next(); }
    if(e.target.matches('.btn-prev')){ e.preventDefault(); prev(); }
  });

  show(0);
})();
</script>
<?php endif; ?>

  
  <section class="prayer-band" aria-hidden="true"></section>

  
  <?php if($hasDonate): ?>
  <section class="donate-card">
    <div class="container">
      <div class="donate-box">

        <figure class="donate-qr">
          <?php if($qrImg): ?>
            <img src="<?php echo e($qrImg); ?>" alt="Swish – Stöd Alby moské">
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/services/show.blade.php ENDPATH**/ ?>
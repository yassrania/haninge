<?php $__env->startSection('title', 'Haninge Islamiska Forum — Välkommen'); ?>

<?php $__env->startSection('content'); ?>
<?php
    /** اجمع كل المتغيرات بشكل آمن + قيم افتراضية */
    $home = $home ?? \App\Models\HomeSetting::first(); // لو ما أُرسل من الكنترولر

    $heroMode    = $home?->hero_mode ?? 'image_slider';
    $slides      = is_array($home?->slides ?? null) ? ($home->slides ?? []) : [];
    $introTitle  = $home?->intro_title  ?? ($home?->about_title ?? 'Alby moské');
    $introAccent = $home?->intro_accent ?? 'En moské i hjärtat av Botkyrka';

    $goals       = is_array($home?->goals ?? null) ? ($home->goals ?? []) : [];
    $pillars     = is_array($home?->pillars ?? null) ? ($home->pillars ?? []) : [];
    $servicesCfg = is_array($home?->services ?? null) ? ($home->services ?? []) : [];

    $goalsTitle  = $home?->goals_title  ?? 'Vårt mål och syfte';
    $goalsAccent = $home?->goals_accent ?? 'Stärka tro, kunskap och gemenskap';

    $latestNews  = isset($latestNews) ? $latestNews : collect(); // يُرسل من الكنترولر عادة
?>


<?php if($heroMode === 'single_image' && !empty($home?->hero_image)): ?>
<section id="hero" class="hero">
  <div class="hero-slider" aria-live="polite">
    <figure class="hero-slide is-active" data-index="0" aria-hidden="false">
      <img class="hero-img" src="<?php echo e(asset('storage/'.$home->hero_image)); ?>" alt="<?php echo e($home->about_title ?? 'hero'); ?>">
      <?php if(!empty($home->about_title) || !empty($home->intro_accent)): ?>
        <figcaption class="hero-caption">
          <?php if(!empty($home->about_title)): ?> <h1><?php echo e($home->about_title); ?></h1> <?php endif; ?>
          <?php if(!empty($home->intro_accent)): ?> <p><?php echo e($home->intro_accent); ?></p> <?php endif; ?>
        </figcaption>
      <?php endif; ?>
    </figure>
  </div>
</section>
<?php elseif(in_array($heroMode, ['image_slider','video_slider']) && count($slides)): ?>
<section id="hero" class="hero">
  <div class="hero-slider" aria-live="polite">
    <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $img   = $s['image'] ?? null;
        $video = $s['video'] ?? null;
      ?>

      <?php if($heroMode === 'image_slider' && $img): ?>
        <figure class="hero-slide <?php echo e($i===0 ? 'is-active':''); ?>" data-index="<?php echo e($i); ?>" aria-hidden="<?php echo e($i===0 ? 'false':'true'); ?>">
          <img class="hero-img" src="<?php echo e(asset('storage/'.$img)); ?>" alt="<?php echo e($s['title'] ?? 'slide'); ?>">
          <?php if(!empty($s['title']) || !empty($s['subtitle'])): ?>
            <figcaption class="hero-caption">
              <?php if(!empty($s['title'])): ?>    <h1><?php echo e($s['title']); ?></h1> <?php endif; ?>
              <?php if(!empty($s['subtitle'])): ?> <p><?php echo e($s['subtitle']); ?></p> <?php endif; ?>
            </figcaption>
          <?php endif; ?>
        </figure>
      <?php elseif($heroMode === 'video_slider' && $video): ?>
        <figure class="hero-slide <?php echo e($i===0 ? 'is-active':''); ?>" data-index="<?php echo e($i); ?>" aria-hidden="<?php echo e($i===0 ? 'false':'true'); ?>">
          <video class="hero-video" muted playsinline preload="<?php echo e($i===0 ? 'auto':'metadata'); ?>" <?php echo e($i===0 ? 'autoplay loop':''); ?>>
            <source src="<?php echo e(asset('storage/'.$video)); ?>" type="<?php echo e(\Illuminate\Support\Str::endsWith($video, '.webm') ? 'video/webm' : 'video/mp4'); ?>">
          </video>
          <?php if(!empty($s['title']) || !empty($s['subtitle'])): ?>
            <figcaption class="hero-caption">
              <?php if(!empty($s['title'])): ?>    <h1><?php echo e($s['title']); ?></h1> <?php endif; ?>
              <?php if(!empty($s['subtitle'])): ?> <p><?php echo e($s['subtitle']); ?></p> <?php endif; ?>
            </figcaption>
          <?php endif; ?>
        </figure>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <?php if(count($slides) > 1): ?>
  <div class="hero-controls" role="tablist" aria-label="Hero slider">
    <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <button class="hero-dot <?php echo e($i === 0 ? 'is-active':''); ?>" role="tab" aria-selected="<?php echo e($i === 0 ? 'true':'false'); ?>" data-go="<?php echo e($i); ?>"></button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <button class="hero-playpause" aria-label="Pausa" data-state="playing">❚❚</button>
  </div>
  <?php endif; ?>
</section>
<?php endif; ?>



<?php if(!empty($introTitle) || !empty($home?->about_body) || !empty($home?->about_image)): ?>
<section class="section intro">
  <div class="container intro-grid">
    <figure class="intro-photo framed">
      <?php if(!empty($home?->about_image)): ?>
        <img src="<?php echo e(asset('storage/'.$home->about_image)); ?>" alt="<?php echo e($introTitle); ?>">
      <?php endif; ?>
    </figure>

    <div class="intro-text">
      <h2 class="section-title"><?php echo e($introTitle); ?></h2>
      <p class="accent-line"><?php echo e($introAccent); ?></p>
      <?php if(!empty($home?->about_body)): ?>
        <div class="text"><?php echo $home->about_body; ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php
    $hasGoals = !empty($goals) && is_array($goals) && count($goals) > 0;
    $g0       = $hasGoals ? ($goals[0] ?? []) : [];
    $g0Body   = is_array($g0) ? ($g0['text'] ?? null) : (string)$g0;
    $g0Img    = is_array($g0) ? ($g0['image'] ?? null) : null;
?>

<?php if($hasGoals): ?>
<section id="goals" class="section goals">
  <div class="container goals-grid">
    <div class="goals-text">
      <?php if(!empty($goalsTitle)): ?>  <h2 class="section-title"><?php echo e($goalsTitle); ?></h2> <?php endif; ?>
      <?php if(!empty($goalsAccent)): ?> <p class="accent-line"><?php echo e($goalsAccent); ?></p> <?php endif; ?>

      <?php if(!empty($g0Body)): ?>
        <p><?php echo e($g0Body); ?></p>
      <?php endif; ?>

      <?php if(count($goals) > 1): ?>
        <ul class="check-list">
          <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($k === 0) continue; ?>
            <?php $txt = is_array($it) ? ($it['text'] ?? null) : (string)$it; ?>
            <?php if(!empty($txt)): ?> <li><?php echo e($txt); ?></li> <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      <?php endif; ?>
    </div>

    <figure class="goals-photo framed">
      <?php if(!empty($g0Img)): ?>
        <img src="<?php echo e(asset('storage/'.$g0Img)); ?>" alt="<?php echo e($goalsTitle); ?>">
      <?php endif; ?>
    </figure>
  </div>
</section>
<?php endif; ?>


<?php if(!empty($pillars) && is_array($pillars) && count($pillars) > 0): ?>
<section class="pillars">
  <div class="container pillars-inner">
    <h2>Islams fem pelare</h2>
    <p>Som en fast grund för det goda livet: tro, bön, givmildhet, fasta och pilgrimsfärd.</p>
    <div class="pillars-grid">
      <?php $__currentLoopData = $pillars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $icon  = is_array($p) ? ($p['icon']  ?? null) : null;
          $label = is_array($p) ? ($p['label'] ?? ($p['title'] ?? null)) : (string)$p;
          $desc  = is_array($p) ? ($p['text']  ?? ($p['body'] ?? null)) : null;
        ?>
        <article class="pillar">
          <?php if(!empty($icon)): ?>  <span class="pillar-ico"><?php echo e($icon); ?></span> <?php endif; ?>
          <?php if(!empty($label)): ?> <h3 class="pillar-title"><?php echo e($label); ?></h3> <?php endif; ?>
          <?php if(!empty($desc)): ?>  <p class="pillar-desc"><?php echo e($desc); ?></p> <?php endif; ?>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<section class="section prayers-block" dir="ltr">
  <div class="container prayers-wrap">

    <figure class="prayers-photo">
      
      <img src="<?php echo e(asset('assets/img/prayer-banner.jpg')); ?>" alt="Bön i moskén">
    </figure>

    
<?php
    // اجلب مواقيت اليوم محليًا لو لم تُمرَّر من الكنترولر
    if (!isset($today)) {
        $today = \App\Models\PrayerTime::whereDate('date', today())->first();
    }
?>

<div class="prayers-card">
  <header class="prayers-card-head">
  </header>

  
  <?php echo $__env->make('partials.prayer-today', ['today' => $today], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php
    $btnT = $home->prayer_button_text ?? 'Visa månadsvis';
    $btnU = $home->prayer_button_url  ?? route('bonetider');
  ?>
  <a class="btn-month" href="<?php echo e($btnU); ?>"><?php echo e($btnT); ?></a>
</div>

  </div>
</section>



 


<?php
    $services = is_array($home->services ?? null) ? $home->services : [];
?>

<?php if(!empty($services)): ?>
<section id="services" class="section services">
  <div class="container">
    <header class="section-head">
      <?php if(!empty($home->services_title)): ?>
        <h2 class="section-title green"><?php echo e($home->services_title); ?></h2>
      <?php endif; ?>
      <?php if(!empty($home->services_desc)): ?>
        <div class="muted"><?php echo $home->services_desc; ?></div>
      <?php endif; ?>
    </header>

    <div class="services-grid">
      <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $img  = $svc['image']       ?? null;
          $tit  = $svc['title']       ?? null;
          $txt  = $svc['text']        ?? null;
          $btnT = $svc['button_text'] ?? null;
          $btnU = $svc['button_url']  ?? null;
        ?>

        <article class="service-card">
          <?php if($img): ?>
            <img src="<?php echo e(asset('storage/'.$img)); ?>" alt="<?php echo e($tit ?? ''); ?>">
          <?php endif; ?>
          <div class="service-body">
            <?php if($tit): ?> <h3><?php echo e($tit); ?></h3> <?php endif; ?>
            <?php if($txt): ?> <p><?php echo e($txt); ?></p>   <?php endif; ?>
            <?php if($btnT && $btnU): ?>
              <a class="btn btn-orange" href="<?php echo e($btnU); ?>"><?php echo e($btnT); ?></a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>

<?php if(isset($latestNews) && $latestNews->count()): ?>
<section class="section news-home">
  <div class="container">
    <header class="section-head">
      <h2 class="section-title green">Senaste nytt</h2>
      <p class="muted">De senaste uppdateringarna från moskén</p>
    </header>

    <div class="news-grid">
      <?php $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <p class="text-center" style="margin-top:20px">
      <a class="btn btn-orange" href="<?php echo e(route('nyheter.index')); ?>">Visa alla nyheter</a>
    </p>
  </div>
</section>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
<style>
/* نفس ستايل شبكة 3 بطاقات اللي استعملناه في صفحة nyheter */
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


<?php endif; ?>

<?php
  $ctaTitle = $home->cta_title ?? null;
  $ctaSub   = $home->cta_subtitle ?? null;
  $ctaBtnT  = $home->cta_button_text ?? null;
  $ctaBtnU  = $home->cta_button_url  ?? null;
  $ctaBg = $home->cta_background ?? null;
?>

<?php if($ctaTitle || $ctaSub || ($ctaBtnT && $ctaBtnU)): ?>
<section class="cta-bg">
<?php if($ctaBg): ?>
    style="--cta-bg: url('<?php echo e(asset('storage/'.$ctaBg)); ?>');"
  <?php endif; ?>
  <div class="cta-overlay">
  <div class="container cta-inner">
    <?php if($ctaTitle): ?>
      <h2><?php echo e($ctaTitle); ?></h2>
    <?php endif; ?>

    <?php if($ctaSub): ?>
      
      <p><?php echo nl2br(e($ctaSub)); ?></p>
    <?php endif; ?>

    <?php if($ctaBtnT && $ctaBtnU): ?>
      <a class="cta-btn" href="<?php echo e($ctaBtnU); ?>"><?php echo e($ctaBtnT); ?></a>
    <?php endif; ?>
  </div>
</div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/home.blade.php ENDPATH**/ ?>
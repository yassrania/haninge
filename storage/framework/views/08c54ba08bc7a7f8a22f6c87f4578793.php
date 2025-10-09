<?php $__env->startSection('title','Nyheter — Haninge Islamiska Forum'); ?>

<?php $__env->startSection('content'); ?>

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('<?php echo e(asset('assets/img/om-islam-banner.jpg')); ?>')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Viktig Påminnelse inför Eid-bönen</h1>
  </div>
</section>

<?php $__env->startSection('title', $pageTitle ?? 'Nyheter'); ?>
<?php $__env->startSection('meta_description', $pageDescription ?? ''); ?>

<?php $__env->startSection('content'); ?>

  
  <section class="page-banner" style="background-image:url('<?php echo e($banner?->banner_path ? Storage::url($banner->banner_path) : '/assets/img/nyheter-banner.jpg'); ?>')">
    <div class="overlay"></div>
    <div class="container banner-inner">
      <h1><?php echo e($banner?->title ?: 'Nyheter'); ?></h1>
      <?php if($banner?->subtitle): ?>
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
                <span><?php echo e(optional($item->published_at)->format('Y-m-d')); ?></span>
                <?php if($item->published_at): ?><span>•</span><span><?php echo e($item->published_at->format('H:i:s')); ?></span><?php endif; ?>
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
/* شبكة 3 أعمدة (Responsive) */
.news-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:24px;
}
@media(max-width:1100px){ .news-grid{ grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px){ .news-grid{ grid-template-columns:1fr;} }

.news-card{
  background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06);
  overflow:hidden; display:flex; flex-direction:column;
}
.news-thumb img{ width:100%; height:220px; object-fit:cover; display:block; }
.news-body{ padding:20px; }
.news-title{ font-size:28px; margin:0 0 8px; }
.news-excerpt{ color:#555; line-height:1.6; }
.news-more{ margin-top:12px; }
.news-meta{
  padding:14px 20px; color:#888; font-size:14px; border-top:1px solid #eee; margin-top:auto;
}
</style>
<?php $__env->stopPush(); ?>


<main class="site-main">
  <!-- ===== News list ===== -->
  <section class="section">
    <div class="container">
      <div class="news-grid nyheter-grid">
        <!-- Card 1 -->
        <article class="news-card">
          <h3>Viktig Påminnelse inför Eid-bönen</h3>
          <p class="excerpt">
            Viktig Påminnelse inför Eid-bönen Kära bröder och systrar. Vi ser fram emot att välkomna er till Eid-bönen. 
            För att säkerställa en smidig och respektfull upplevelse …
          </p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-03-28</span>
            <span class="time">18:18:34</span>
          </footer>
        </article>

        <!-- Card 2 -->
        <article class="news-card">
          <h3>Viktig Påminnelse inför Eid-bönen</h3>
          <p class="excerpt">Viktig Påminnelse inför Eid-bönen Kära bröder och systrar. Vi ser fram emot att välkomna er …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-03-24</span>
            <span class="time">13:51:56</span>
          </footer>
        </article>

        <!-- Card 3 -->
        <article class="news-card">
          <h3>Extra årsmöte och fyllnadsval</h3>
          <p class="excerpt">Vi tackar alla våra medlemmar som har närvarat vid extra årsmötet och fyllnadsval …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-23</span>
            <span class="time">21:33:51</span>
          </footer>
        </article>

        <!-- Card 4 -->
        <article class="news-card">
          <h3>Ramadan imsakiy e (Bönetider)</h3>
          <p class="excerpt">Ladda ner bönetider för Ramadan …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-21</span>
            <span class="time">14:51:48</span>
          </footer>
        </article>

        <!-- Card 5 -->
        <article class="news-card">
          <h3>Fyllnadsval Extra Årsmöte 23/02-2025</h3>
          <p class="excerpt">Styrelsen har skickat kallelse via e-post den 2 februari 2025 och den 9 februari 2025 via telefonnummer …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-09</span>
            <span class="time">15:20:09</span>
          </footer>
        </article>

        <!-- Card 6 -->
        <article class="news-card">
          <h3>Medlems avgift för interna medlemmar</h3>
          <p class="excerpt">Esselamu aleykom Kära bröder och systrar! Som alla känner till så har vi erbjudit alla våra stöd medlemmar till …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2024-10-28</span>
            <span class="time">20:38:21</span>
          </footer>
        </article>
      </div>

      <!-- Pagination -->
      <nav class="pager" aria-label="Sidanavigering">
        <a class="page disabled" href="#" aria-disabled="true">« Föregående</a>
        <a class="page is-active" href="#">1</a>
        <a class="page" href="#">2</a>
        <a class="page" href="#">3</a>
        <a class="page" href="#">Nästa »</a>
      </nav>
    </div>
  </section>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/nyheter.blade.php ENDPATH**/ ?>
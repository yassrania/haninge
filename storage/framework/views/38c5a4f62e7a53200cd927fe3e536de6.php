<?php $__env->startSection('title','Bönetider — Haninge Islamiska Forum'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // إدخال الشهر/السنة الافتراضيين
    $year  = isset($year)  ? (int) $year  : now()->year;
    $month = isset($month) ? (int) $month : now()->month;

    // تواريخ التنقّل
    $cur  = \Illuminate\Support\Carbon::create($year, $month, 1)->locale('sv');
    $prev = (clone $cur)->subMonth();
    $next = (clone $cur)->addMonth();

    $monthName = ucfirst($cur->translatedFormat('F'));

    use Illuminate\Support\Carbon;

    // فورمات التاريخ
    $formatDate = function ($d) {
        $c = $d instanceof Carbon ? $d : Carbon::parse($d);
        $c->locale('sv');
        return $c->translatedFormat('j F, Y');
    };

    // تنسيق وقت مختصر
    $val = fn($t) => $t ? e($t) : '--:--';
?>

<style>
  /* ===== A4 print setup ===== */
  @page { size: A4 portrait; margin: 12mm; }
  html, body { height: 100%; background:#fff; }

  /* Buttons/filters should not print */
  @media print { .no-print { display: none !important; } }

  /* Keep the monthly table on one page */
  @media print {
    .calendar-a4, .calendar-a4 table { page-break-inside: avoid; }
  }

  /* ===== Golden frame background wrapper ===== */
  .calendar-a4-wrap { display:flex; justify-content:center; }
  .calendar-a4 {
    width: 210mm;                 /* A4 width */
    min-height: 297mm;            /* A4 height */
    position: relative;
    padding: 28mm 16mm 16mm;      /* move table inside the arch */
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    background: transparent;
    margin: 0 auto;
  }
  .calendar-a4::before {
    content: "";
    position: absolute; inset: 0;
    background: url("<?php echo e(asset('img/bonetider-frame.png')); ?>") no-repeat center top;
    background-size: contain;     /* show full frame */
    z-index: 0;
  }
  .calendar-a4 > * { position: relative; z-index: 1; }

  /* ===== Monthly table styling ===== */
  .bonetider-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11pt;              /* adjust if it overflows */
    background: transparent;
  }
  .bonetider-table th, .bonetider-table td {
    padding: 6px 8px;
    border: 1px solid #b8b8b8;
    text-align: center;
  }
  .bonetider-table thead th {
    background: #f6f6f6;
  }
  .monthly-row { cursor: pointer; }
  .monthly-row:hover { background-color: rgba(0,0,0,.03); }

  /* Daily card is great on screen, but we’ll hide it on print so the A4 is clean */
  @media print { .daily-card { display: none !important; } }
</style>

<section class="container py-4">
  
  <div class="d-flex align-items-center justify-content-between mb-3 no-print">
    <h1 class="h4 m-0">Bönetider – <?php echo e(ucfirst($monthName)); ?> <?php echo e($cur->year); ?></h1>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary"
         href="<?php echo e(route('bonetider', ['year' => $prev->year, 'month' => $prev->month])); ?>">‹ Föregående</a>
      <a class="btn btn-outline-secondary"
         href="<?php echo e(route('bonetider', ['year' => now()->year, 'month' => now()->month])); ?>">Idag</a>
      <a class="btn btn-outline-secondary"
         href="<?php echo e(route('bonetider', ['year' => $next->year, 'month' => $next->month])); ?>">Nästa ›</a>
      <button type="button" class="btn btn-primary" onclick="window.print()">Skriv ut</button>
    </div>
  </div>

  
  <form class="row g-2 mb-4 no-print" method="get" action="<?php echo e(route('bonetider')); ?>">
    <div class="col-auto">
      <label class="form-label">Månad</label>
      <select name="month" class="form-select">
        <?php for($m = 1; $m <= 12; $m++): ?>
          <?php $mName = \Illuminate\Support\Carbon::create($cur->year, $m, 1)->locale('sv')->translatedFormat('F'); ?>
          <option value="<?php echo e($m); ?>" <?php if($m === (int) $cur->month): echo 'selected'; endif; ?>><?php echo e(ucfirst($mName)); ?></option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="col-auto">
      <label class="form-label">År</label>
      <input type="number" class="form-control" name="year" value="<?php echo e((int) $cur->year); ?>" min="2020" max="2100">
    </div>
    <div class="col-auto align-self-end">
      <button class="btn btn-primary">Visa</button>
    </div>
  </form>

  <div class="row g-4">
    
    <div class="col-12 col-lg-8">
      <div class="calendar-a4-wrap">
        <div class="calendar-a4">
          <h2 class="h5 text-center mb-2" style="font-weight:700;">
            <?php echo e(ucfirst($monthName)); ?> <?php echo e($cur->year); ?>

          </h2>

          <table class="bonetider-table" aria-label="Månatliga bönetider">
            <thead>
              <tr>
                <th>Datum</th>
                <th>Fajr</th>
                <th>Soluppgång</th>
                <th>Dhuhr</th>
                <th>Asr</th>
                <th>Maghrib</th>
                <th>Isha</th>
              </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <?php $dateStr = $formatDate($r->date); ?>
              <tr class="monthly-row"
                  role="button"
                  tabindex="0"
                  data-date="<?php echo e($dateStr); ?>"
                  data-fajr="<?php echo e($val($r->fajr)); ?>"
                  data-sunrise="<?php echo e($val($r->sunrise)); ?>"
                  data-dhuhr="<?php echo e($val($r->dhuhr)); ?>"
                  data-asr="<?php echo e($val($r->asr)); ?>"
                  data-maghrib="<?php echo e($val($r->maghrib)); ?>"
                  data-isha="<?php echo e($val($r->isha)); ?>">
                <td><?php echo e($dateStr); ?></td>
                <td><?php echo e($val($r->fajr)); ?></td>
                <td><?php echo e($val($r->sunrise)); ?></td>
                <td><?php echo e($val($r->dhuhr)); ?></td>
                <td><?php echo e($val($r->asr)); ?></td>
                <td><?php echo e($val($r->maghrib)); ?></td>
                <td><?php echo e($val($r->isha)); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="7" class="text-muted">Inga tider hittades för denna månad.</td>
              </tr>
            <?php endif; ?>
            </tbody>
          </table>

          
          <p class="text-center text-muted mt-2 no-print" style="font-size:12px;">
            Aktivera <em>Background graphics</em> / <em>Bakgrundsbilder</em> i utskriftsdialogen för att skriva ut den gyllene ramen.
          </p>
        </div>
      </div>
    </div>

    
    <div class="col-12 col-lg-4 daily-card">
      <div class="card shadow-sm">
        <div class="card-header">
          <strong>Idag</strong>
        </div>
        <div class="card-body">
          <?php
            $todayRec = $records->firstWhere('date', $cur->copy()->day(1)); // placeholder; اضبطها حسب بياناتك
          ?>

          <div class="mb-3">
            <div class="fw-bold" id="daily-date"><?php echo e($formatDate(now())); ?></div>
          </div>

          <dl class="row mb-0">
            <dt class="col-6">Fajr</dt>      <dd class="col-6" id="daily-fajr"><?php echo e($todayRec ? $val($todayRec->fajr) : '--:--'); ?></dd>
            <dt class="col-6">Soluppgång</dt><dd class="col-6" id="daily-sunrise"><?php echo e($todayRec ? $val($todayRec->sunrise) : '--:--'); ?></dd>
            <dt class="col-6">Dhuhr</dt>     <dd class="col-6" id="daily-dhuhr"><?php echo e($todayRec ? $val($todayRec->dhuhr) : '--:--'); ?></dd>
            <dt class="col-6">Asr</dt>       <dd class="col-6" id="daily-asr"><?php echo e($todayRec ? $val($todayRec->asr) : '--:--'); ?></dd>
            <dt class="col-6">Maghrib</dt>   <dd class="col-6" id="daily-maghrib"><?php echo e($todayRec ? $val($todayRec->maghrib) : '--:--'); ?></dd>
            <dt class="col-6">Isha</dt>      <dd class="col-6" id="daily-isha"><?php echo e($todayRec ? $val($todayRec->isha) : '--:--'); ?></dd>
          </dl>
        </div>
        <div class="card-footer text-muted small">
          Klicka på en rad i månadslistan för att uppdatera dagliga tider.
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.monthly-row');
    const setDaily = (tr) => {
      if (!tr) return;
      document.getElementById('daily-date')?.textContent   = tr.dataset.date || '';
      document.getElementById('daily-fajr')?.textContent    = tr.dataset.fajr || '--:--';
      document.getElementById('daily-sunrise')?.textContent = tr.dataset.sunrise || '--:--';
      document.getElementById('daily-dhuhr')?.textContent   = tr.dataset.dhuhr || '--:--';
      document.getElementById('daily-asr')?.textContent     = tr.dataset.asr || '--:--';
      document.getElementById('daily-maghrib')?.textContent = tr.dataset.maghrib || '--:--';
      document.getElementById('daily-isha')?.textContent    = tr.dataset.isha || '--:--';
    };

    rows.forEach(tr => {
      tr.addEventListener('click', () => setDaily(tr));
      tr.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setDaily(tr); }
      });
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\haninge\resources\views/pages/bonetider.blade.php ENDPATH**/ ?>
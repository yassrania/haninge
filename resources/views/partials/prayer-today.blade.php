@php
  // عنوان افتراضي (يمكن تمريره من الخارج بـ $title)
  $title = $title
      ?? ($home->prayer_title ?? 'Bönetider i Haninge');

  // حماية لو ما فيه بيانات اليوم
  $t = $today ?? null;

  // حوّل "HH:MM" إلى كائن وقت في تاريخ اليوم
  $mk = function (?string $hmm) {
      if (!$hmm) return null;
      return \Illuminate\Support\Carbon::createFromFormat(
          'Y-m-d H:i', today()->format('Y-m-d').' '.$hmm
      );
  };

  $now  = now();
  $rows = collect([
      ['key'=>'fajr',    'label'=>'Fajr',    'time'=>$mk($t?->fajr)],
      ['key'=>'sunrise', 'label'=>'Shuruk',  'time'=>$mk($t?->sunrise)],
      ['key'=>'dhuhr',   'label'=>'Dhohr',   'time'=>$mk($t?->dhuhr)],
      ['key'=>'asr',     'label'=>'Asr',     'time'=>$mk($t?->asr)],
      ['key'=>'maghrib', 'label'=>'Maghrib', 'time'=>$mk($t?->maghrib)],
      ['key'=>'isha',    'label'=>'Isha',    'time'=>$mk($t?->isha)],
  ]);

  // الصلاة القادمة
  $next = $rows->first(fn($r) => $r['time'] && $r['time']->greaterThan($now));
@endphp

<div class="pt-vert">
  <div class="pt-head">
    <h3 class="pt-title">{{ $title }}</h3>
    <small class="pt-date">
  {{ now()->locale('sv')->translatedFormat('l d F Y') }}
</small>

  </div>

  <ul class="pt-list">
    @foreach($rows as $r)
      @php
        $timeText = $r['time'] ? $r['time']->format('H:i') : '—';
        $isNext   = $next && $next['key'] === $r['key'];
      @endphp
      <li class="pt-row {{ $isNext ? 'is-next' : '' }}">
        <span class="pt-label">{{ $r['label'] }}</span>
        <span class="pt-time">{{ $timeText }}</span>
      </li>
    @endforeach
  </ul>
</div>

<style>
/* تخطيط عمودي بسيط مثل الصورة الثانية */
.pt-vert{padding:8px 6px;background:transparent}
.pt-head{ text-align:center; margin-bottom:8px; }
.pt-title{ margin:0; font-weight:700; }
.pt-date{ opacity:.85; }

.pt-list{ list-style:none; margin:12px 0 0; padding:0; }
.pt-row{
  display:flex; justify-content:space-between; align-items:center;
  padding:10px 6px;
  border-bottom:1px dashed rgba(255,255,255,.7); /* خطوط متقطعة */
}
.pt-row:last-child{ border-bottom:0; }
.pt-label{ opacity:.95; }
.pt-time{ font-weight:700; }

/* تمييز الصلاة القادمة بخط سفلي بسيط فقط */
.pt-row.is-next .pt-time{ text-decoration: underline; }
</style>

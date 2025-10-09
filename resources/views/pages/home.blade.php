@extends('layouts.app')
@section('title', 'Haninge Islamiska Forum — Välkommen')

@section('content')
@php
    $home = \App\Models\HomeSetting::query()->first();

    $slides   = is_array($home->slides ?? null) ? $home->slides : [];
    $goals    = is_array($home->goals    ?? null) ? $home->goals    : [];
    $pillars  = is_array($home->pillars  ?? null) ? $home->pillars  : [];
    $services = is_array($home->services ?? null) ? $home->services : [];

    $introTitle  = $home->intro_title  ?: ($home->about_title ?? 'Alby moské');
    $introAccent = $home->intro_accent ?: 'En moské i hjärtat av Botkyrka';

    $goalsTitle  = $home->goals_title  ?? 'Vårt mål och syfte';
    $goalsAccent = $home->goals_accent ?? 'Stärka tro, kunskap och gemenskap';

      $heroMode = $home->hero_mode ?? 'image_slider';

@endphp

{{-- ===== INTRO (هيدر صغير) ===== --}}
@php
  $heroMode = $home->hero_mode ?? 'image_slider';
  $slides   = is_array($home->slides ?? null) ? $home->slides : [];
@endphp

{{-- ===== HERO ===== --}}
@php
  $heroMode = $home->hero_mode ?? 'image_slider';
  $slides   = is_array($home->slides ?? null) ? $home->slides : [];
@endphp

{{-- ===== HERO ===== --}}
@if($heroMode === 'single_image' && !empty($home?->hero_image))
<section id="hero" class="hero">
  <div class="hero-slider" aria-live="polite">
    <figure class="hero-slide is-active" data-index="0" aria-hidden="false">
      <img class="hero-img" src="{{ asset('storage/'.$home->hero_image) }}" alt="{{ $home->about_title ?? 'hero' }}">
      @if(!empty($home->about_title) || !empty($home->intro_accent))
        <figcaption class="hero-caption">
          @if(!empty($home->about_title)) <h1>{{ $home->about_title }}</h1> @endif
          @if(!empty($home->intro_accent)) <p>{{ $home->intro_accent }}</p> @endif
        </figcaption>
      @endif
    </figure>
  </div>
</section>
@elseif(in_array($heroMode, ['image_slider','video_slider']) && count($slides))
<section id="hero" class="hero">
  <div class="hero-slider" aria-live="polite">
    @foreach($slides as $i => $s)
      @php
        $img   = $s['image'] ?? null;
        $video = $s['video'] ?? null;
      @endphp

      @if($heroMode === 'image_slider' && $img)
        <figure class="hero-slide {{ $i===0 ? 'is-active':'' }}" data-index="{{ $i }}" aria-hidden="{{ $i===0 ? 'false':'true' }}">
          <img class="hero-img" src="{{ asset('storage/'.$img) }}" alt="{{ $s['title'] ?? 'slide' }}">
          @if(!empty($s['title']) || !empty($s['subtitle']))
            <figcaption class="hero-caption">
              @if(!empty($s['title']))    <h1>{{ $s['title'] }}</h1> @endif
              @if(!empty($s['subtitle'])) <p>{{ $s['subtitle'] }}</p> @endif
            </figcaption>
          @endif
        </figure>
      @elseif($heroMode === 'video_slider' && $video)
        <figure class="hero-slide {{ $i===0 ? 'is-active':'' }}" data-index="{{ $i }}" aria-hidden="{{ $i===0 ? 'false':'true' }}">
          <video class="hero-video" muted playsinline preload="{{ $i===0 ? 'auto':'metadata' }}" {{ $i===0 ? 'autoplay loop':'' }}>
            <source src="{{ asset('storage/'.$video) }}" type="{{ \Illuminate\Support\Str::endsWith($video, '.webm') ? 'video/webm' : 'video/mp4' }}">
          </video>
          @if(!empty($s['title']) || !empty($s['subtitle']))
            <figcaption class="hero-caption">
              @if(!empty($s['title']))    <h1>{{ $s['title'] }}</h1> @endif
              @if(!empty($s['subtitle'])) <p>{{ $s['subtitle'] }}</p> @endif
            </figcaption>
          @endif
        </figure>
      @endif
    @endforeach
  </div>

  @if(count($slides) > 1)
  <div class="hero-controls" role="tablist" aria-label="Hero slider">
    @foreach($slides as $i => $s)
      <button class="hero-dot {{ $i === 0 ? 'is-active':'' }}" role="tab" aria-selected="{{ $i === 0 ? 'true':'false' }}" data-go="{{ $i }}"></button>
    @endforeach
    <button class="hero-playpause" aria-label="Pausa" data-state="playing">❚❚</button>
  </div>
  @endif
</section>
@endif


{{-- ===== INTRO سكشن كامل ===== --}}
@if(!empty($introTitle) || !empty($home?->about_body) || !empty($home?->about_image))
<section class="section intro">
  <div class="container intro-grid">
    <figure class="intro-photo framed">
      @if(!empty($home?->about_image))
        <img src="{{ asset('storage/'.$home->about_image) }}" alt="{{ $introTitle }}">
      @endif
    </figure>

    <div class="intro-text">
      <h2 class="section-title">{{ $introTitle }}</h2>
      <p class="accent-line">{{ $introAccent }}</p>
      @if(!empty($home?->about_body))
        <div class="text">{!! $home->about_body !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ===== GOALS ===== --}}
@php
    $hasGoals = !empty($goals) && is_array($goals) && count($goals) > 0;
    $g0       = $hasGoals ? ($goals[0] ?? []) : [];
    $g0Body   = is_array($g0) ? ($g0['text'] ?? null) : (string)$g0;
    $g0Img    = is_array($g0) ? ($g0['image'] ?? null) : null;
@endphp

@if($hasGoals)
<section id="goals" class="section goals">
  <div class="container goals-grid">
    <div class="goals-text">
      @if(!empty($goalsTitle))  <h2 class="section-title">{{ $goalsTitle }}</h2> @endif
      @if(!empty($goalsAccent)) <p class="accent-line">{{ $goalsAccent }}</p> @endif

      @if(!empty($g0Body))
        <p>{{ $g0Body }}</p>
      @endif

      @if(count($goals) > 1)
        <ul class="check-list">
          @foreach($goals as $k => $it)
            @continue($k === 0)
            @php $txt = is_array($it) ? ($it['text'] ?? null) : (string)$it; @endphp
            @if(!empty($txt)) <li>{{ $txt }}</li> @endif
          @endforeach
        </ul>
      @endif
    </div>

    <figure class="goals-photo framed">
      @if(!empty($g0Img))
        <img src="{{ asset('storage/'.$g0Img) }}" alt="{{ $goalsTitle }}">
      @endif
    </figure>
  </div>
</section>
@endif

{{-- ===== PILLARS (اختياري) ===== --}}
@if(!empty($pillars) && is_array($pillars) && count($pillars) > 0)
<section class="pillars">
  <div class="container pillars-inner">
    <h2>Islams fem pelare</h2>
    <p>Som en fast grund för det goda livet: tro, bön, givmildhet, fasta och pilgrimsfärd.</p>
    <div class="pillars-grid">
      @foreach($pillars as $p)
        @php
          $icon  = is_array($p) ? ($p['icon']  ?? null) : null;
          $label = is_array($p) ? ($p['label'] ?? ($p['title'] ?? null)) : (string)$p;
          $desc  = is_array($p) ? ($p['text']  ?? ($p['body'] ?? null)) : null;
        @endphp
        <article class="pillar">
          @if(!empty($icon))  <span class="pillar-ico">{{ $icon }}</span> @endif
          @if(!empty($label)) <h3 class="pillar-title">{{ $label }}</h3> @endif
          @if(!empty($desc))  <p class="pillar-desc">{{ $desc }}</p> @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== BÖNETIDER (تصميم أصلي + بيانات ديناميكية) ===== --}}
<section class="section prayers-block" dir="ltr">
  <div class="container prayers-wrap">

    <figure class="prayers-photo">
      {{-- غيّر المسار أدناه لو عندك الصورة في مكان آخر --}}
      <img src="{{ asset('assets/img/prayer-banner.jpg') }}" alt="Bön i moskén">
    </figure>

    <div class="prayers-card">
      <header class="prayers-card-head">
        <h3>{{ $home->prayer_title ?? 'Bönetider i Haninge' }}</h3>
        <small id="prayers-date">Idag</small>
      </header>

      <table class="prayers-table">
        <tbody id="prayers-body">
          <tr><th>Fajr</th>    <td id="pv-fajr">—</td></tr>
          <tr><th>Solupp</th>  <td id="pv-sunrise">—</td></tr>
          <tr><th>Dhuhr</th>   <td id="pv-dhuhr">—</td></tr>
          <tr><th>Asr</th>     <td id="pv-asr">—</td></tr>
          <tr><th>Maghrib</th> <td id="pv-maghrib">—</td></tr>
          <tr><th>Isha</th>    <td id="pv-isha">—</td></tr>
        </tbody>
      </table>

      @php
        $btnT = $home->prayer_button_text ?? 'Visa månadsvis';
        $btnU = $home->prayer_button_url  ?? '#';
      @endphp
      <a class="btn-month" href="{{ $btnU }}">{{ $btnT }}</a>
    </div>
  </div>
</section>

@push('scripts')
<script>
(() => {
  // تنسيق التاريخ السويدي أعلى البطاقة
  const dateEl = document.getElementById('prayers-date');
  try { dateEl.textContent = new Intl.DateTimeFormat('sv-SE', { dateStyle: 'full' }).format(new Date()); }
  catch(e){ dateEl.textContent = 'Idag'; }

  // عناصر الأوقات
  const el = {
    fajr:    document.getElementById('pv-fajr'),
    sunrise: document.getElementById('pv-sunrise'),
    dhuhr:   document.getElementById('pv-dhuhr'),
    asr:     document.getElementById('pv-asr'),
    maghrib: document.getElementById('pv-maghrib'),
    isha:    document.getElementById('pv-isha'),
  };

  // تحويل "HH:MM (CEST)" إلى "HH:MM"
  const hhmm = (s) => String(s || '').split(' ')[0];

  // تحميل مواقيت اليوم من AlAdhan (يعتمد على خط العرض/الطول)
  function loadTimings(lat, lng) {
    const ts = Math.floor(Date.now()/1000); // اليوم
    const tz = encodeURIComponent('Europe/Stockholm');
    // method=3 (Muslim World League) — عدلها إن لزم
    const url = `https://api.aladhan.com/v1/timings/${ts}?latitude=${lat}&longitude=${lng}&method=3&school=0&timezonestring=${tz}`;
    fetch(url)
      .then(r => r.json())
      .then(({data}) => {
        if (!data || !data.timings) throw new Error('No timings');
        const t = data.timings;

        if (el.fajr)    el.fajr.textContent    = hhmm(t.Fajr    || t.fajr);
        if (el.sunrise) el.sunrise.textContent = hhmm(t.Sunrise || t.sunrise);
        if (el.dhuhr)   el.dhuhr.textContent   = hhmm(t.Dhuhr   || t.dhuhr || t.Zuhr);
        if (el.asr)     el.asr.textContent     = hhmm(t.Asr     || t.asr);
        if (el.maghrib) el.maghrib.textContent = hhmm(t.Maghrib || t.maghrib);
        if (el.isha)    el.isha.textContent    = hhmm(t.Isha    || t.isha);
      })
      .catch(() => {
        // لو فشل الجلب، على الأقل خلّي التاريخ موجود والباقي شرطات —
      });
  }

  // إحداثيات احتياطية: Botkyrka/Haninge تقريبًا
  const fallback = { lat: 59.2239, lng: 17.8390 };

  // تحديد الموقع من المتصفح (ثم سقوط احتياطي)
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      pos => loadTimings(pos.coords.latitude, pos.coords.longitude),
      ()  => loadTimings(fallback.lat, fallback.lng),
      { timeout: 5000 }
    );
  } else {
    loadTimings(fallback.lat, fallback.lng);
  }
})();
</script>
@endpush


@php
    $services = is_array($home->services ?? null) ? $home->services : [];
@endphp

@if(!empty($services))
<section id="services" class="section services">
  <div class="container">
    <header class="section-head">
      @if(!empty($home->services_title))
        <h2 class="section-title green">{{ $home->services_title }}</h2>
      @endif
      @if(!empty($home->services_desc))
        <div class="muted">{!! $home->services_desc !!}</div>
      @endif
    </header>

    <div class="services-grid">
      @foreach($services as $svc)
        @php
          $img  = $svc['image']       ?? null;
          $tit  = $svc['title']       ?? null;
          $txt  = $svc['text']        ?? null;
          $btnT = $svc['button_text'] ?? null;
          $btnU = $svc['button_url']  ?? null;
        @endphp

        <article class="service-card">
          @if($img)
            <img src="{{ asset('storage/'.$img) }}" alt="{{ $tit ?? '' }}">
          @endif
          <div class="service-body">
            @if($tit) <h3>{{ $tit }}</h3> @endif
            @if($txt) <p>{{ $txt }}</p>   @endif
            @if($btnT && $btnU)
              <a class="btn btn-orange" href="{{ $btnU }}">{{ $btnT }}</a>
            @endif
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

@if(isset($latestNews) && $latestNews->count())
<section class="section news-home">
  <div class="container">
    <header class="section-head">
      <h2 class="section-title green">Senaste nytt</h2>
      <p class="muted">De senaste uppdateringarna från moskén</p>
    </header>

    <div class="news-grid">
      @foreach($latestNews as $item)
        <article class="news-card">
          <a href="{{ route('nyheter.show', $item->slug) }}" class="news-thumb">
            @if($item->image_path)
              <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}">
            @endif
          </a>

          <div class="news-body">
            <h3 class="news-title">
              <a href="{{ route('nyheter.show', $item->slug) }}">{{ $item->title }}</a>
            </h3>

            @if($item->excerpt)
              <p class="news-excerpt">{{ $item->excerpt }}</p>
            @endif

            <p class="news-more">
              <a href="{{ route('nyheter.show', $item->slug) }}" class="btn-link">Läs mer »</a>
            </p>
          </div>

          <div class="news-meta">
            @if($item->published_at)
              <span>{{ $item->published_at->format('Y-m-d') }}</span>
              <span>•</span>
              <span>{{ $item->published_at->format('H:i:s') }}</span>
            @endif
          </div>
        </article>
      @endforeach
    </div>

    <p class="text-center" style="margin-top:20px">
      <a class="btn btn-orange" href="{{ route('nyheter.index') }}">Visa alla nyheter</a>
    </p>
  </div>
</section>
@endif

@push('styles')
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
@endpush


@endif
{{-- ===== CTA (من الأدمن) ===== --}}
@php
  $ctaTitle = $home->cta_title ?? null;
  $ctaSub   = $home->cta_subtitle ?? null;
  $ctaBtnT  = $home->cta_button_text ?? null;
  $ctaBtnU  = $home->cta_button_url  ?? null;
  $ctaBg = $home->cta_background ?? null;
@endphp

@if($ctaTitle || $ctaSub || ($ctaBtnT && $ctaBtnU))
<section class="cta-bg">
@if($ctaBg)
    style="--cta-bg: url('{{ asset('storage/'.$ctaBg) }}');"
  @endif
  <div class="cta-overlay">
  <div class="container cta-inner">
    @if($ctaTitle)
      <h2>{{ $ctaTitle }}</h2>
    @endif

    @if($ctaSub)
      {{-- نحافظ على أسطر جديدة إن وُجدت --}}
      <p>{!! nl2br(e($ctaSub)) !!}</p>
    @endif

    @if($ctaBtnT && $ctaBtnU)
      <a class="cta-btn" href="{{ $ctaBtnU }}">{{ $ctaBtnT }}</a>
    @endif
  </div>
</div>
</section>
@endif

@endsection

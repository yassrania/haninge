@php
    use App\Models\HomeSetting;
    /** @var HomeSetting|null $home */
    $home = HomeSetting::query()->first();

    // تحويلات آمنة للمصفوفات
    $slides   = (array) ($home->slides   ?? []);
    $goals    = (array) ($home->goals    ?? []);
    $pillars  = (array) ($home->pillars  ?? []);
    $services = (array) ($home->services ?? []);

    // عناوين ديناميكية + fallbacks
    $introTitle  = $home->intro_title  ?: ($home->about_title ?? 'Alby moské');
    $introAccent = $home->intro_accent ?: 'En moské i hjärtat av Botkyrka';
$gBody = null;
    foreach ($goals as $item) {
        if (!empty($item['body'])) { $gBody = $item['body']; break; }
    }

    $gImage = $goals[0]['image'] ?? null; // الصورة الأولى فقط (بحسب تصميمك)
    $goalsTitle  = $home->goals_title  ?? 'Vårt mål och syfte';
    $goalsAccent = $home->goals_accent ?? 'Stärka tro, kunskap och gemenskap';
@endphp
    

@extends('layouts.app')
@section('title', 'Alby Moské — Välkommen')

@section('content')

{{-- ===== HERO (مجرّد عنوان فرعي هنا حسب قوالبك) ===== --}}
<section id="hero" class="hero">
  <div class="container hero-inner">
    <h1 class="hero-title">{{ $introTitle }}</h1>
    <p class="hero-subtitle">{{ $introAccent }}</p>
  </div>
</section>

{{-- ===== INTRO ===== --}}
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
        {{-- RichEditor: اعرض HTML كما هو --}}
        <div class="text">{!! $home->about_body !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ===== VÅRT MÅL OCH SYFTE (Goals) ===== --}}
@if(count($goals))
<section id="goals" class="section goals">
  <div class="container goals-grid">

    <div class="goals-text">
      <h2 class="section-title">{{ $goalsTitle }}</h2>
      <p class="accent-line">{{ $goalsAccent }}</p>

      {{-- ما بقاش نستعمل body ديال أول عنصر كـ "وصف عام" باش مايوقعش خلط --}}
      @if(!empty($home?->goals_intro))
        <p>{{ $home->goals_intro }}</p>
      @endif

   
      {{-- هُنا الوصف اللي كتكتب فـ "Beskrivning" ديال الـGoals (Repeater) --}}
      @if(!empty($gBody))
        <p>{!! nl2br(e($gBody)) !!}</p>
      @else
        {{-- ما كاين حتى وصف مُدخل فالعناصر --}}
      @endif
    </div>

    <figure class="goals-photo framed">
      @if(!empty($gImage))
        <img src="{{ asset('storage/'.$gImage) }}" alt="{{ $goalsTitle }}">
      @endif
    </figure>

  </div>
</section>
@endif

{{-- ===== ISLAMS PELARE ===== --}}
@if(count($pillars))
<section class="pillars"style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="container pillars-inner">
    <h2>Islams fem pelare</h2>
    <p>Som en fast grund för det goda livet: tro, bön, givmildhet, fasta och pilgrimsfärd.</p>

    <div class="pillars-grid">
      @foreach($pillars as $p)
        <article class="pillar">
          @if(!empty($p['icon']))
            <span class="pillar-ico"><i class="{{ $p['icon'] }}"></i></span>
          @endif

          @if(!empty($p['title']))
            <h3 class="pillar-title">{{ $p['title'] }}</h3>
          @endif

          {{-- هنا كان المشكل: الوصف ماكانش كيتعرض. درناه صريحاً --}}
          @if(!empty($p['body']))
            <p class="pillar-desc">{{ $p['body'] }}</p>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif



{{-- ===== Bönetider (صورة + بطاقة) ===== --}}
<section class="section prayers-block" dir="ltr">
  <div class="container prayers-wrap">
    <figure class="prayers-photo">
      {{-- ما عندناش حقل للصورة هنا فـ HomeSetting، ممكن تضيفه لاحقاً.
           دابا كنخلي صورة ثابتة من assets باش التصميم يبقى كما هو --}}
      <img src="/assets/img/prayer-banner.jpg" alt="Bön i moskén">
    </figure>

    <div class="prayers-card">
      <header class="prayers-card-head">
        <h3>{{ $home->prayer_title ?? 'Bönetider i Botkyrka' }}</h3>
        <small>Idag</small>
      </header>

      {{-- حقل النص العام --}}
      @if(!empty($home?->prayer_body))
        <div class="muted" style="padding:0 10px 8px">{{ $home->prayer_body }}</div>
      @endif

      {{-- جدول توضيحي (ثابت حالياً) --}}
      <table class="prayers-table">
        <tbody>
          <tr><th>Fajr</th><td>05:10</td></tr>
          <tr><th>Solupp</th><td>06:31</td></tr>
          <tr><th>Dhuhr</th><td>12:55</td></tr>
          <tr><th>Asr</th><td>16:15</td></tr>
          <tr><th>Maghrib</th><td>19:04</td></tr>
          <tr><th>Isha</th><td>20:34</td></tr>
        </tbody>
      </table>

      @if(!empty($home?->prayer_button_text) && !empty($home?->prayer_button_url))
        <a class="btn-month" href="{{ $home->prayer_button_url }}">{{ $home->prayer_button_text }}</a>
      @endif
    </div>
  </div>
</section>

{{-- ===== Våra tjänster ===== --}}
@if(!empty($home?->services_title) || !empty($home?->services_desc) || count($services))
<section id="services" class="section services">
  <div class="container">
    <header class="section-head">
      <h2 class="section-title green">{{ $home->services_title ?? 'Våra tjänster' }}</h2>
      <p class="muted">{{ $home->services_desc ?? 'Vi erbjuder en rad tjänster för vår församling i Botkyrka.' }}</p>
    </header>

    <div class="services-grid">
      @forelse($services as $srv)
        <article class="service-card">
          @if(!empty($srv['image']))
            <img src="{{ asset('storage/'.$srv['image']) }}" alt="{{ $srv['title'] ?? '' }}">
          @else
            <img src="/assets/img/services/prayer.jpg" alt="Tjänst">
          @endif
          <div class="service-body">
            <h3>{{ $srv['title'] ?? '' }}</h3>
            <p>{{ $srv['body'] ?? '' }}</p>
            @if(!empty($srv['button_text']) && !empty($srv['button_url']))
              <a class="btn btn-orange" href="{{ $srv['button_url'] }}">{{ $srv['button_text'] }}</a>
            @endif
          </div>
        </article>
      @empty
        {{-- fallback كارتات ثابتة إلى أن تضيف خدمات من لوحة التحكم --}}
      @endforelse
    </div>
  </div>
</section>
@endif

{{-- ===== CTA بخلفية ===== --}}
@if(!empty($home?->cta_title) || !empty($home?->cta_subtitle) || (!empty($home?->cta_button_text) && !empty($home?->cta_button_url)))
<section class="cta-bg">
  <div class="cta-overlay"></div>
  <div class="container cta-inner">
    <h2>{{ $home->cta_title ?? 'En plats för dig' }}</h2>
    <p>
      {{ $home->cta_subtitle ?? 'Bli en del av oss på Alby moskén, bli medlem!' }}
    </p>
    @if(!empty($home?->cta_button_text) && !empty($home?->cta_button_url))
      <a class="cta-btn" href="{{ $home->cta_button_url }}">{{ $home->cta_button_text }}</a>
    @endif
  </div>
</section>
@endif

{{-- ===== Senaste nytt ===== --}}
@if(!empty($home?->show_latest_news))
  @php
    $limit = (int) ($home->latest_news_limit ?? 6);
    try { $latest = \App\Models\Blog::query()->latest()->take($limit)->get(); }
    catch (\Throwable $e) { $latest = collect(); }
  @endphp

  @if($latest->count())
  <section id="news" class="section news">
    <div class="container">
      <header class="section-head">
        <h2 class="section-title green">Senaste nytt</h2>
      </header>

      <div class="news-grid">
        @foreach($latest as $post)
          <article class="news-card">
            <h3>
              <a href="{{ route('blog.show', $post->slug ?? $post->id) }}">{{ $post->title }}</a>
            </h3>
            <p class="meta">{{ optional($post->created_at)->format('d M Y') }} • Alby</p>
            @if(!empty($post->excerpt))
              <p>{{ $post->excerpt }}</p>
            @endif
            <a href="{{ route('blog.show', $post->slug ?? $post->id) }}" class="readmore">Läs mer</a>
          </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif
@endif

{{-- ===== Footer ===== --}}
{{-- من layout: @includeIf('partials.footer') --}}

@endsection

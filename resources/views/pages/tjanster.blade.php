@php
    use App\Models\ServicesPageSetting;

    $s = ServicesPageSetting::first();

    // Banner
    $banner = $s?->banner ? asset('storage/'.$s->banner) : asset('assets/img/om-islam-banner.jpg');
    $title  = $s?->title ?? 'Våra tjänster';
    $sub    = $s?->subtitle ?? null;

    // Kort
    $cardsTitle = $s?->cards_section_title ?? null;
    $cardsSub   = $s?->cards_section_subtitle ?? null;
    $cardsDesc  = $s?->cards_section_description ?? null;
    $cards      = (array) ($s?->cards ?? []);

    // Utbildning
    $eduTitle = $s?->education_title ?? null;
    $eduSub   = $s?->education_subtitle ?? null;
    $eduDesc  = $s?->education_description ?? null;
    $edu      = (array) ($s?->education_items ?? []);
@endphp

@extends('layouts.app')
@section('title', $title)

@section('content')

{{-- ===== Banner ===== --}}
<section class="page-banner" style="background-image:url('{{ $banner }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>{{ $title }}</h1>
    @if($sub)<p>{{ $sub }}</p>@endif
  </div>
</section>

<main>

  {{-- ===== KORT (العناوين العامة + الكروت) ===== --}}
  @if($cardsTitle || $cardsSub || $cardsDesc || count($cards))
  <section class="section">
    <div class="container">
      @if($cardsTitle)<h2 class="section-title">{{ $cardsTitle }}</h2>@endif
      @if($cardsSub)<h6 class="orange">{{ $cardsSub }}</h6>@endif
      @if($cardsDesc)<div class="text">{!! $cardsDesc !!}</div>@endif

      @foreach($cards as $c)
        @php
          $img   = !empty($c['image']) ? asset('storage/'.$c['image']) : null;
          $posRaw= strtolower(trim($c['image_position'] ?? 'left'));
          // دعم كتابات متعددة لليمين
          $pos   = in_array($posRaw, ['right','höger','hoger']) ? 'right' : 'left';
        @endphp

        <div class="prayer-grid {{ $pos === 'right' ? 'img-right' : 'img-left' }}" style="margin-bottom:28px">
          <figure class="prayer-frame frame">
            @if($img)<img src="{{ $img }}" alt="{{ $c['title'] ?? '' }}">@endif
          </figure>

          <div class="prayer-text">
            @if(!empty($c['title']))    <h2 class="green">{{ $c['title'] }}</h2>@endif
            @if(!empty($c['subtitle'])) <h6 class="orange">{{ $c['subtitle'] }}</h6>@endif
            @if(!empty($c['body']))     <div class="text">{!! $c['body'] !!}</div>@endif
            @if(!empty($c['button_text']) && !empty($c['button_url']))
              <a class="btn-orange" href="{{ $c['button_url'] }}">{{ $c['button_text'] }}</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- فاصل ديكوري اختياري --}}
  <section class="prayer-band" aria-hidden="true"></section>
  @endif

  {{-- ===== UTBILDNING ===== --}}
  @if($eduTitle || $eduSub || $eduDesc || count($edu))
  <section class="section">
    <div class="container">
      @if($eduTitle)<h2 class="section-title">{{ $eduTitle }}</h2>@endif
      @if($eduSub)  <h6 class="orange">{{ $eduSub }}</h6>@endif
      @if($eduDesc) <div class="text">{!! $eduDesc !!}</div>@endif

      @foreach($edu as $e)
        @php
          $eImg = !empty($e['image']) ? asset('storage/'.$e['image']) : null;
          $ePos = in_array(strtolower(trim($e['image_position'] ?? 'left')), ['right','höger','hoger']) ? 'right' : 'left';
        @endphp

        <div class="prayer-grid {{ $ePos === 'right' ? 'img-right' : 'img-left' }}" style="margin-bottom:28px">
          <figure class="prayer-frame frame">
            @if($eImg)<img src="{{ $eImg }}" alt="{{ $e['title'] ?? '' }}">@endif
          </figure>

          <div class="prayer-text">
            @if(!empty($e['title']))    <h3 class="green">{{ $e['title'] }}</h3>@endif
            @if(!empty($e['subtitle'])) <h6 class="orange">{{ $e['subtitle'] }}</h6>@endif
            @if(!empty($e['body']))     <div class="text">{!! $e['body'] !!}</div>@endif
            @if(!empty($e['button_text']) && !empty($e['button_url']))
              <a class="btn-orange" href="{{ $e['button_url'] }}">{{ $e['button_text'] }}</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </section>
  @endif

</main>
@endsection

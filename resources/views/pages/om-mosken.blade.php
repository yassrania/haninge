@extends('layouts.app')

@section('title', $pageTitle ?? 'Om Mosken')
@section('meta_description', $pageDescription ?? 'Haninge Islamiska Forum')

@section('content')

  {{-- ===== Banner (مثل Om Islam) ===== --}}
  @php $banners = $sections->where('type', 'banner'); @endphp
  @if($banners->count())
    @php $b = $banners->first(); @endphp
    <section class="page-banner" style="background-image:url('{{ $b->banner_path ? Storage::url($b->banner_path) : '/assets/img/om-mosken-banner.jpg' }}')">
      <div class="overlay"></div>
      <div class="container banner-inner">
        <h1>{{ $b->title ?: 'Om Mosken' }}</h1>
        @if(!empty($b->subtitle))
          <p>{{ $b->subtitle }}</p>
        @elseif(!empty($b->slug))
          <p>{{ $b->slug }}</p>
        @endif
      </div>
    </section>
  @else
    <section class="page-banner" style="background-image:url('/assets/img/om-mosken-banner.jpg')">
      <div class="overlay"></div>
      <div class="container banner-inner">
        <h1>Om Mosken</h1>
        <p>Välkommen</p>
      </div>
    </section>
  @endif

  <main class="site-main">
    @php $blocks = $sections->reject(fn($s) => $s->type === 'banner')->values(); @endphp

    {{-- ===== باقي البلوكات (Image+Text / Text) بنفس ستايل om-islam ===== --}}
    @foreach($blocks as $block)
      @if($block->type === 'image_text')
        @php
          $imageHtml   = $block->image_path ? '<img src="'.e(Storage::url($block->image_path)).'" alt="'.e($block->title).'" />' : '';
          $figureClass = 'frame';
          $pos         = ($block->image_position === 'right') ? 'right' : 'left';
        @endphp

        <section class="section about-grid">
          <div class="container grid-2">
            @if($pos === 'left')
              <figure class="{{ $figureClass }}">{!! $imageHtml !!}</figure>
              <div>
                @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
                @if($block->subtitle)<h6 class="orange">{{ $block->subtitle }}</h6>@endif
                @if($block->content){!! $block->content !!}@endif
                @if($block->button_url)
                  <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
                @endif
              </div>
            @endif

            @if($pos === 'right')
              <div>
                @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
                @if($block->subtitle)<h6 class="orange">{{ $block->subtitle }}</h6>@endif
                @if($block->content){!! $block->content !!}@endif
                @if($block->button_url)
                  <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
                @endif
              </div>
              <figure class="{{ $figureClass }}">{!! $imageHtml !!}</figure>
            @endif
          </div>
        </section>
      @elseif($block->type === 'text')
        <section class="section">
          <div class="container">
            @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
            @if($block->subtitle)<p>{{ $block->subtitle }}</p>@endif
            @if($block->content){!! $block->content !!}@endif
          </div>
        </section>
      @endif
    @endforeach

    {{-- ===== Donera (شرطي) ===== --}}
    @if($hasDonate)
      <section class="donate-card">
        <div class="container">
          <div class="donate-box">
            <figure class="donate-qr">
              @if($qrImg)
                <img src="{{ $qrImg }}" alt="Swish – Stöd moskén">
              @endif
            </figure>
            <div class="donate-text">
              @if($dTitle)  <h2 class="green">{{ $dTitle }}</h2> @endif
              @if($dSub)    <h5 class="deep">{{ $dSub }}</h5>   @endif
              @if($dBody)   <div class="text">{!! $dBody !!}</div> @endif
              @if($dBtnTxt && $dBtnUrl)
                <a href="{{ $dBtnUrl }}" class="btn-orange">{{ $dBtnTxt }}</a>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

  </main>
@endsection

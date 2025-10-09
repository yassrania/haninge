@extends('layouts.app')

@section('title', $pageTitle ?? 'Om Islam')
@section('meta_description', $pageDescription ?? 'Haninge Islamiska Forum')

@section('content')

  {{-- ===== Banner Om Islam ===== --}}
  @php $banners = $sections->where('type', 'banner'); @endphp
  @if($banners->count())
      @php $b = $banners->first(); @endphp
      <section class="page-banner" style="background-image:url('{{ $b->banner_path ? Storage::url($b->banner_path) : '/assets/img/om-islam-banner.jpg' }}')">
        <div class="overlay"></div>
        <div class="container banner-inner">
          <h1>{{ $b->title ?: 'Om Islam' }}</h1>
          @if($b->subtitle ?? false)
            <p>{{ $b->subtitle }}</p>
          @elseif($b->slug ?? false)
            <p>{{ $b->slug }}</p>
          @endif
        </div>
      </section>
  @else
      {{-- لو ما في بنر من الـCMS نعرض واحد افتراضي عشان نحافظ على نفس الستايل --}}
      <section class="page-banner" style="background-image:url('/assets/img/om-islam-banner.jpg')">
        <div class="overlay"></div>
        <div class="container banner-inner">
          <h1>Om Islam</h1>
          <p>En introduktion</p>
        </div>
      </section>
  @endif

  <main class="site-main">

    @php
      // بقية البلوكات غير البنر
      $blocks = $sections->reject(fn($s) => $s->type === 'banner')->values();
    @endphp

    @forelse($blocks as $idx => $block)

      {{-- ===== Image + Text (about-grid) بنفس تنسيق القالب الأصلي مع تبادل يمين/يسار تلقائي --}}
    @if($block->type === 'image_text')
  @php
      $imageHtml = $block->image_path
          ? '<img src="'.e(Storage::url($block->image_path)).'" alt="'.e($block->title).'" />'
          : '';
      $figureClass = 'frame';
      $pos = ($block->image_position === 'right') ? 'right' : 'left';
  @endphp

  <section class="section about-grid">
    <div class="container grid-2">

      {{-- صورة يسار + نص يمين --}}
      @if($pos === 'left')
        <figure class="{{ $figureClass }}">{!! $imageHtml !!}</figure>
        <div>
          @if($block->title)
            <h2 class="green">{{ $block->title }}</h2>
          @endif

          @if($block->subtitle)
            <h6 class="orange">{{ $block->subtitle }}</h6>
          @endif

          @if($block->content)
            {!! $block->content !!}
          @endif

          @if($block->button_url)
            <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
          @endif
        </div>
      @endif

      {{-- نص يسار + صورة يمين --}}
      @if($pos === 'right')
        <div>
          @if($block->title)
            <h2 class="green">{{ $block->title }}</h2>
          @endif

          @if($block->subtitle)
            <p>{{ $block->subtitle }}</p>
          @endif

          @if($block->content)
            {!! $block->content !!}
          @endif

          @if($block->button_url)
            <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
          @endif
        </div>
        <figure class="{{ $figureClass }}">{!! $imageHtml !!}</figure>
      @endif

    </div>
  </section>



      {{-- ===== Text فقط: نفس بنية <section class="section"> --}}
      @elseif($block->type === 'text')
        @php
          // لو حاب تعمل مقطع أخضر كامل مثل "section-green" في الأصلي:
          // اكتب في Subtitle بالـCMS كلمة section-green (اختياري)
          $isGreen = trim((string)($block->subtitle ?? '')) === 'section-green';
        @endphp

        @if($isGreen)
          <section class="section about-grid">
    <div class="container grid-2">
              @if($block->title)<h2 class="white">{{ $block->title }}</h2>@endif
              @if($block->content)
                <div class="white">{!! $block->content !!}</div>
              @endif
              {{-- لو محتاج اقتباس بشكل خاص: ضع <blockquote class="islam-quote"> داخل محتوى الـCMS --}}
            </div>
          </section>
        @else
          <section class="section">
            <div class="container">
              @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
              @if($block->subtitle && $block->subtitle !== 'section-green')
                <p>{{ $block->subtitle }}</p>
              @endif
              @if($block->content){!! $block->content !!}@endif
            </div>
          </section>
        @endif
      @endif

    @empty
      {{-- لو ما في بلوكات نعرض Placeholder بسيط بنفس المسافات --}}
      <section class="section">
        <div class="container">
          <h2 class="green">Om Islam</h2>
          <p>Innehållet kommer snart.</p>
        </div>
      </section>
    @endforelse

  </main>

@endsection

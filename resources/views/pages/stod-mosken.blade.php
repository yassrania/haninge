@extends('layouts.app')

@section('title', $pageTitle ?? 'Stöd moskén')
@section('meta_description', $pageDescription ?? '')

@section('content')

{{-- Banner بسيط (اختياري) --}}


<main class="site-main section">
  <div class="container" style="display:grid;grid-template-columns:1fr 340px;gap:40px;">
    <div class="support-main">

      @foreach($sections as $block)
        @if($block->type === 'image_text')
          @php
            $pos = $block->image_position === 'right' ? 'right' : 'left';
            $img = $block->image_path ? Storage::url($block->image_path) : null;
          @endphp
          <section class="section about-grid">
            <div class="container grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
              @if($pos==='left')
                <figure class="frame">
                  @if($img)<img src="{{ $img }}" alt="{{ $block->title }}">@endif
                </figure>
              @endif

              <div>
                @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
                @if($block->subtitle)<p>{{ $block->subtitle }}</p>@endif
                @if($block->content)<div class="text">{!! $block->content !!}</div>@endif
                @if($block->button_url)
                  <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
                @endif
              </div>

              @if($pos==='right')
                <figure class="frame">
                  @if($img)<img src="{{ $img }}" alt="{{ $block->title }}">@endif
                </figure>
              @endif
            </div>
          </section>

        @elseif($block->type === 'image')
          @if($block->image_path)
          <section class="section">
            <figure class="frame">
              <img src="{{ Storage::url($block->image_path) }}" alt="{{ $block->title }}">
            </figure>
            @if($block->title)<h2 class="green" style="margin-top:12px">{{ $block->title }}</h2>@endif
            @if($block->subtitle)<p>{{ $block->subtitle }}</p>@endif
            @if($block->button_url)
              <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
            @endif
          </section>
          @endif

        @elseif($block->type === 'text')
          <section class="section">
            @if($block->title)<h2 class="green">{{ $block->title }}</h2>@endif
            @if($block->subtitle)<p>{{ $block->subtitle }}</p>@endif
            @if($block->content)<div class="text">{!! $block->content !!}</div>@endif
            @if($block->button_url)
              <p><a class="btn-link" href="{{ $block->button_url }}">{{ $block->button_label ?: 'Läs mer' }}</a></p>
            @endif
          </section>
        @endif
      @endforeach

    </div>

    {{-- ================= Sidebar ================= --}}
    <aside class="support-aside tight-top">
      <div class="sticky" style="position:sticky;top:24px;">
        <div class="card" style="background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.06);padding:18px;">
          @if($aside?->title)<h3 class="green">{{ $aside->title }}</h3>@endif
          @if($aside?->body)<div class="text" style="margin-top:8px">{!! $aside->body !!}</div>@endif

          @if($aside?->image_path)
            <figure class="frame" style="margin-top:12px">
              <img src="{{ Storage::url($aside->image_path) }}" alt="Support">
            </figure>
          @endif

          @if($aside?->button_label && $aside?->button_url)
            <p style="margin-top:12px">
              <a class="btn-orange" href="{{ $aside->button_url }}">{{ $aside->button_label }}</a>
            </p>
          @endif

          @if($aside?->extra_image_path)
            <figure class="frame" style="margin-top:12px">
              <img src="{{ Storage::url($aside->extra_image_path) }}" alt="Support">
            </figure>
          @endif
        </div>
      </div>
    </aside>
  </div>
</main>

@endsection

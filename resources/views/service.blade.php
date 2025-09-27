@php
  /** @var \App\Models\Service $service */
  $rows = (array) ($service->service_rows ?? []);
@endphp

@extends('layouts.app')
@section('title', $service->title)

@section('content')

{{-- Banner --}}
@if($service->page_banner)
<section class="page-banner">
  <img src="{{ asset('storage/'.$service->page_banner) }}" alt="{{ $service->title }}">
</section>
@endif

{{-- Header --}}
<section class="section">
  <div class="container">
    <h1 class="section-title">{{ $service->title }}</h1>
    @if($service->subtitle)
      <p class="accent-line">{{ $service->subtitle }}</p>
    @endif
  </div>
</section>

{{-- Service rows --}}
@if(count($rows))
  @foreach($rows as $r)
  <section class="service-row">
    <div class="container service-grid">
      <figure class="service-photo">
        @if(!empty($r['photo']))
          <img src="{{ asset('storage/'.$r['photo']) }}" alt="{{ $r['title'] ?? $service->title }}">
        @endif
      </figure>
      <div class="service-text">
        @if(!empty($r['title']))    <h2 class="section-title">{{ $r['title'] }}</h2> @endif
        @if(!empty($r['subtitle'])) <p class="accent-line">{{ $r['subtitle'] }}</p> @endif
        @if(!empty($r['description']))
          <div class="text">{!! nl2br(e($r['description'])) !!}</div>
        @endif
      </div>
    </div>
  </section>
  @endforeach
@endif

{{-- Islams fem pelare (من Startsida) --}}
@if(!empty($pillars))
<section class="pillars">
  <div class="container pillars-inner">
    <h2>Islams fem pelare</h2>
    <div class="pillars-grid">
      @foreach($pillars as $p)
        <article class="pillar">
          @if(!empty($p['icon']))  <span class="pillar-ico"><i class="{{ $p['icon'] }}"></i></span> @endif
          @if(!empty($p['title'])) <h3 class="pillar-title">{{ $p['title'] }}</h3> @endif
          @if(!empty($p['body']))  <p class="pillar-desc">{{ $p['body'] }}</p> @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- Utbildning – Vuxna --}}
@if($service->utbildning_vuxna_title || $service->utbildning_vuxna_desc || $service->utbildning_vuxna_photo)
<section class="utbildning vuxna">
  <div class="container service-grid">
    <figure class="service-photo">
      @if($service->utbildning_vuxna_photo)
        <img src="{{ asset('storage/'.$service->utbildning_vuxna_photo) }}" alt="{{ $service->utbildning_vuxna_title ?? 'Vuxna' }}">
      @endif
    </figure>
    <div class="service-text">
      @if($service->utbildning_vuxna_title)
        <h2 class="section-title">{{ $service->utbildning_vuxna_title }}</h2>
      @endif
      @if($service->utbildning_vuxna_desc)
        <div class="text">{!! nl2br(e($service->utbildning_vuxna_desc)) !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- Utbildning – Barn --}}
@if($service->utbildning_barn_title || $service->utbildning_barn_desc || $service->utbildning_barn_photo)
<section class="utbildning barn">
  <div class="container service-grid">
    <figure class="service-photo">
      @if($service->utbildning_barn_photo)
        <img src="{{ asset('storage/'.$service->utbildning_barn_photo) }}" alt="{{ $service->utbildning_barn_title ?? 'Barn' }}">
      @endif
    </figure>
    <div class="service-text">
      @if($service->utbildning_barn_title)
        <h2 class="section-title">{{ $service->utbildning_barn_title }}</h2>
      @endif
      @if($service->utbildning_barn_desc)
        <div class="text">{!! nl2br(e($service->utbildning_barn_desc)) !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

@endsection

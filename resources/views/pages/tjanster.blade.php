@php
    use App\Models\TjansterPage;
    use App\Models\HomeSetting;

    /** @var TjansterPage|null $page */
    $page = TjansterPage::query()->first();

    $rows    = (array) ($page->service_rows ?? []);
    $pillars = (array) (HomeSetting::query()->first()->pillars ?? []);
@endphp

@extends('layouts.app')

@section('title', 'Tjänster')

@section('content')

{{-- ===== Banner ===== --}}
@if(!empty($page?->page_banner))
<section class="page-banner">
    <img src="{{ asset('storage/'.$page->page_banner) }}" alt="Tjänster">
</section>
@endif

{{-- ===== Service rows (1..4) ===== --}}
@if(count($rows))
    @foreach($rows as $i => $r)
    <section class="service-row">
        <div class="container service-grid">
            <figure class="service-photo">
                @if(!empty($r['photo']))
                    <img src="{{ asset('storage/'.$r['photo']) }}" alt="{{ $r['title'] ?? 'Tjänst' }}">
                @endif
            </figure>
            <div class="service-text">
                @if(!empty($r['title']))
                    <h2 class="section-title">{{ $r['title'] }}</h2>
                @endif
                @if(!empty($r['subtitle']))
                    <p class="accent-line">{{ $r['subtitle'] }}</p>
                @endif
                @if(!empty($r['description']))
                    <div class="text">{!! nl2br(e($r['description'])) !!}</div>
                @endif
            </div>
        </div>
    </section>
    @endforeach
@endif

{{-- ===== Islams fem pelare ===== --}}
@if(count($pillars))
<section class="pillars">
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
          @if(!empty($p['body']))
            <p class="pillar-desc">{{ $p['body'] }}</p>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== Utbildning – Vuxna ===== --}}
@if(!empty($page?->utbildning_vuxna_title) || !empty($page?->utbildning_vuxna_desc) || !empty($page?->utbildning_vuxna_photo))
<section class="utbildning vuxna">
  <div class="container service-grid">
    <figure class="service-photo">
      @if(!empty($page?->utbildning_vuxna_photo))
        <img src="{{ asset('storage/'.$page->utbildning_vuxna_photo) }}" alt="{{ $page->utbildning_vuxna_title ?? 'Vuxna' }}">
      @endif
    </figure>
    <div class="service-text">
      @if(!empty($page?->utbildning_vuxna_title))
        <h2 class="section-title">{{ $page->utbildning_vuxna_title }}</h2>
      @endif
      @if(!empty($page?->utbildning_vuxna_desc))
        <div class="text">{!! nl2br(e($page->utbildning_vuxna_desc)) !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ===== Utbildning – Barn ===== --}}
@if(!empty($page?->utbildning_barn_title) || !empty($page?->utbildning_barn_desc) || !empty($page?->utbildning_barn_photo))
<section class="utbildning barn">
  <div class="container service-grid">
    <figure class="service-photo">
      @if(!empty($page?->utbildning_barn_photo))
        <img src="{{ asset('storage/'.$page->utbildning_barn_photo) }}" alt="{{ $page->utbildning_barn_title ?? 'Barn' }}">
      @endif
    </figure>
    <div class="service-text">
      @if(!empty($page?->utbildning_barn_title))
        <h2 class="section-title">{{ $page->utbildning_barn_title }}</h2>
      @endif
      @if(!empty($page?->utbildning_barn_desc))
        <div class="text">{!! nl2br(e($page->utbildning_barn_desc)) !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

@endsection

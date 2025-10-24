@extends('layouts.app')

@section('title', $service->title ?? 'Tjänst')

@section('content')
  @php
    $serviceTitle = $service->title ?? \Illuminate\Support\Str::headline(str_replace('-', ' ', $service->slug));
    $serviceSlug  = $service->slug;

    // خرائط صور افتراضية حسب الـ slug (عدّلها كما تريد)
    $images = [
      'boner-och-gudsdyrkan' => 'services/prayer.JPG',
      'islamisk-begravning'  => 'services/funeral.JPG',
      'radgivning'           => 'services/advice.JPG',
      'utbildning'           => 'services/education.JPG',
      'vigsel'               => 'services/wedding.JPG',
    ];
    $img = $images[$serviceSlug] ?? 'goals-1.JPG';
  @endphp

  <section class="page container">
    <h1 class="mb-3">{{ $serviceTitle }}</h1>

    <img src="{{ asset('assets/img/'.$img) }}" alt="{{ $serviceSlug }}" style="max-width:100%;height:auto;">

    <div class="mt-4">
      {{-- اعرض المحتوى الديناميكي إن وُجد --}}
      @if(!empty($service->body))
        {!! $service->body !!}
      @elseif(!empty($service->content))
        {!! $service->content !!}
      @else
        <p>Detaljer om tjänsten kommer här…</p>
      @endif
    </div>
  </section>
@endsection

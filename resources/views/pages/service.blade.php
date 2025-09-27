@extends('layouts.app')

@section('title','Tjänst')

@section('content')
  <section class="page container">
    <h1>
      Tjänst:
      {{ \Illuminate\Support\Str::headline(str_replace('-', ' ', $slug)) }}
    </h1>

    @php
      $images = [
        'boner-och-gudsdyrkan' => 'services/prayer.JPG',
        'islamisk-begravning'  => 'services/funeral.JPG',
        'radgivning'           => 'services/advice.JPG',
        'utbildning'           => 'services/education.JPG',
      ];
      $img = $images[$slug] ?? 'goals-1.JPG';
    @endphp

    <img src="{{ asset('assets/img/'.$img) }}" alt="{{ $slug }}" style="max-width:100%;height:auto;">
    <div class="mt-4">
      {{-- الصق هنا محتوى صفحة الخدمة من pages/services/{slug}.html لاحقاً --}}
      <p>Detaljer om tjänsten kommer här…</p>
    </div>
  </section>
@endsection

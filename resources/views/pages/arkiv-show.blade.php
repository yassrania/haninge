@extends('layouts.app')
@section('title', $archive->title)

@section('content')
<style>
  /* يمنع أي تمرير أفقي */
  body { overflow-x: hidden; }

  /* اكسر الكلمات الطويلة داخل المحتوى */
  .archive-content { white-space: normal; word-break: break-word; overflow-wrap: anywhere; }

  /* صور المعرض */
  .archive-gallery img {
    width: 100%; height: 220px; object-fit: cover;
    border-radius: .5rem; display: block;
  }
  @media (min-width: 992px) {
    .archive-gallery img { height: 260px; }
  }
</style>

<div class="container py-4">
  <div class="mb-2">
    <a href="{{ route('arkiv.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Tillbaka</a>
  </div>

  <h1 class="mb-1">{{ $archive->title }}</h1>
  @if($archive->event_date)
    <div class="text-muted mb-3">{{ $archive->event_date->format('Y-m-d') }}</div>
  @endif

  {{-- معرض صور --}}
  @if(is_array($archive->images) && count($archive->images))
    <div class="row g-3 mb-4 archive-gallery">
      @foreach($archive->images as $img)
        <div class="col-6 col-md-4 col-lg-3">
          <a href="{{ asset('storage/'.$img) }}" target="_blank" rel="noopener">
            <img src="{{ asset('storage/'.$img) }}" alt="">
          </a>
        </div>
      @endforeach
    </div>
  @endif

  {{-- المحتوى النصي --}}
  @if($archive->body)
    <div class="archive-content">{!! $archive->body !!}</div>
  @elseif($archive->excerpt)
    <p class="text-muted archive-content">{{ $archive->excerpt }}</p>
  @else
    <p class="text-muted">Ingen text.</p>
  @endif
</div>
@endsection

@extends('layouts.app')
@section('title','Arkiv')

@section('content')
<style>
  /* يمنع أي تمدد أفقي */
  body { overflow-x: hidden; }

  /* الكارت */
  .archive-card { overflow: hidden; }
  .archive-title { margin: 0; }

  /* النصوص: اكسر الكلمات الطويلة */
  .archive-text { white-space: normal; word-break: break-word; overflow-wrap: anywhere; }

  /* صورة المصغّر */
  .archive-thumb {
    width: 160px; height: 120px;
    object-fit: cover; border-radius: .5rem;
    display: block;
  }

  /* اجعل رابط العنصر display:block ليتصرف ككارت من دون تمدد */
  .archive-link { display: block; }
</style>

<div class="container py-4">
  <h1 class="mb-3">Arkiv</h1>

  @if($archives->isEmpty())
    <p class="text-muted">Inga poster ännu.</p>
  @else
    <div class="list-group">
      @foreach($archives as $a)
        <a class="list-group-item list-group-item-action archive-card archive-link" href="{{ route('arkiv.show', $a->slug) }}">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="archive-title">{{ $a->title }}</h5>
            @if($a->event_date)
              <small>{{ $a->event_date->format('Y-m-d') }}</small>
            @endif
          </div>

          @if($a->excerpt)
            <p class="mb-2 text-muted archive-text">
              {{ \Illuminate\Support\Str::limit(strip_tags($a->excerpt), 200) }}
            </p>
          @endif

          @php $first = is_array($a->images) && count($a->images) ? $a->images[0] : null; @endphp
          @if($first)
            <img src="{{ asset('storage/'.$first) }}" alt="" class="archive-thumb mt-1">
          @endif
        </a>
      @endforeach
    </div>

    <div class="mt-3">
      {{ $archives->links() }}
    </div>
  @endif
</div>
@endsection

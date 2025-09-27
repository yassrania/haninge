@extends('layouts.app')
@section('title', 'Tjänster')

@section('content')
<section class="section">
  <div class="container">
    <h1 class="section-title">Tjänster</h1>
    <p class="accent-line">Utforska våra tjänster</p>

    <div class="cards">
      @forelse($services as $s)
        <article class="card">
          @if($s->page_banner)
            <img src="{{ asset('storage/'.$s->page_banner) }}" alt="{{ $s->title }}">
          @endif
          <h3><a href="{{ route('service.show', $s->slug) }}">{{ $s->title }}</a></h3>
          @if($s->subtitle)<p class="muted">{{ $s->subtitle }}</p>@endif
          <a class="btn" href="{{ route('service.show', $s->slug) }}">Läs mer</a>
        </article>
      @empty
        <p>Inga tjänster ännu.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection

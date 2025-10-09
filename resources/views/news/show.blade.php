@extends('layouts.app')

@section('title', $pageTitle ?? $nyhet->title)
@section('meta_description', $pageDescription ?? '')

@section('content')

  {{-- Banner بسيط (يمكن لاحقاً تعمل Banner خاص للتفاصيل) --}}
  

  <main class="site-main">
    <section class="section">
      <div class="container">
        <article class="news-article">
          @if($nyhet->image_path)
            <figure class="news-figure">
              <img src="{{ Storage::url($nyhet->image_path) }}" alt="{{ $nyhet->title }}">
            </figure>
          @endif

          @if($nyhet->excerpt)
            <p class="lead">{{ $nyhet->excerpt }}</p>
          @endif

          @if($nyhet->body)
            <div class="prose">{!! $nyhet->body !!}</div>
          @endif
        </article>
      </div>
    </section>
  </main>

@endsection

@push('styles')
<style>
.news-figure img{ width:100%; height:auto; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); margin-bottom:16px; }
.lead{ font-size:18px; color:#444; margin-bottom:16px; }
.prose p{ line-height:1.8; margin:0 0 1em; }
</style>
@endpush

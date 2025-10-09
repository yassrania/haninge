@extends('layouts.app')

@section('title', $pageTitle ?? 'Nyheter — Haninge Islamiska Forum')
@section('meta_description', $pageDescription ?? '')

@section('content')

  {{-- ===== Banner ===== --}}
  <section class="page-banner" style="background-image:url('{{ $banner?->banner_path ? Storage::url($banner->banner_path) : asset('assets/img/nyheter-banner.jpg') }}')">
    <div class="overlay"></div>
    <div class="container banner-inner">
      <h1>{{ $banner->title ?? 'Nyheter' }}</h1>
      @if(!empty($banner?->subtitle))
        <p>{{ $banner->subtitle }}</p>
      @endif
    </div>
  </section>

  {{-- ===== Grid 3 بطاقات ===== --}}
  <main class="site-main">
    <section class="section">
      <div class="container">
        <div class="news-grid">
          @forelse($nyheter as $item)
            <article class="news-card">
              <a href="{{ route('nyheter.show', $item->slug) }}" class="news-thumb">
                @if($item->image_path)
                  <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}">
                @endif
              </a>

              <div class="news-body">
                <h3 class="news-title">
                  <a href="{{ route('nyheter.show', $item->slug) }}">{{ $item->title }}</a>
                </h3>

                @if($item->excerpt)
                  <p class="news-excerpt">{{ $item->excerpt }}</p>
                @endif

                <p class="news-more">
                  <a href="{{ route('nyheter.show', $item->slug) }}" class="btn-link">Läs mer »</a>
                </p>
              </div>

              <div class="news-meta">
                @if($item->published_at)
                  <span>{{ $item->published_at->format('Y-m-d') }}</span>
                  <span>•</span>
                  <span>{{ $item->published_at->format('H:i:s') }}</span>
                @endif
              </div>
            </article>
          @empty
            <p class="text-center text-gray-500">Inga nyheter ännu.</p>
          @endforelse
        </div>
      </div>
    </section>
  </main>

@endsection

@push('styles')
<style>
.news-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
@media(max-width:1100px){ .news-grid{ grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px){ .news-grid{ grid-template-columns:1fr;} }

.news-card{ background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.06); overflow:hidden; display:flex; flex-direction:column; }
.news-thumb img{ width:100%; height:220px; object-fit:cover; display:block; }
.news-body{ padding:20px; }
.news-title{ font-size:28px; margin:0 0 8px; }
.news-excerpt{ color:#555; line-height:1.6; }
.news-more{ margin-top:12px; }
.news-meta{ padding:14px 20px; color:#888; font-size:14px; border-top:1px solid #eee; margin-top:auto; }
</style>
@endpush

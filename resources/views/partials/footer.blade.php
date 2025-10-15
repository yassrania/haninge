@php
  $footer = $footer ?? \App\Models\FooterSetting::first();
  $footerGroups = $footerGroups ?? \App\Models\FooterLinkGroup::with('links')->get();
  $servicesGroup = $footerGroups->firstWhere('name', 'Våra tjänster') ?? $footerGroups->first();

  $site = $site ?? \App\Models\Setting::first();
  $social = is_array($site?->social) ? $site->social : [];
@endphp

<footer class="site-footer">
  <div class="container footer-grid">
    <div class="foot-col">
      @if($footer?->logo)
        <img src="{{ Storage::disk('public')->url($footer->logo) }}" alt="Logo" class="foot-logo">
      @endif
    </div>

    <div class="foot-col">
      <h3 class="foot-title">Våra tjänster</h3>
      @if($servicesGroup && $servicesGroup->links && $servicesGroup->links->count())
        <ul class="foot-links">
          @foreach($servicesGroup->links as $lnk)
            <li><a href="{{ $lnk->url }}">{{ $lnk->title }}</a></li>
          @endforeach
        </ul>
      @else
        <p class="muted">Inga länkar.</p>
      @endif
    </div>

    <div class="foot-col">
      
      @php $today = \App\Models\PrayerTime::whereDate('date', today())->first(); @endphp
      @include('partials.prayer-today', ['today' => $today, 'title' => null])
    </div>

    <div class="foot-col">
      <h3 class="foot-title">Kontaktuppgifter</h3>

      @if($footer?->address)
        <p class="foot-line"><i class="fa-solid fa-location-dot"></i> {{ $footer->address }}</p>
      @endif
      @if($footer?->phone)
        <p class="foot-line"><i class="fa-solid fa-phone"></i>
          <a href="tel:{{ preg_replace('/\s+/', '', $footer->phone) }}">{{ $footer->phone }}</a></p>
      @endif
      @if($footer?->email)
        <p class="foot-line"><i class="fa-solid fa-envelope"></i>
          <a href="mailto:{{ $footer->email }}">{{ $footer->email }}</a></p>
      @endif
      @if($footer?->bankgiro)
        <p class="foot-line"><i class="fa-solid fa-coins"></i> Bankgiro: {{ $footer->bankgiro }}</p>
      @endif
      @if(!empty($footer?->swish_number))
     <p class="foot-line"><strong><i class="fa-solid fa-coins"></i>Swish:</strong> {{ $footer->swish_number }}</p>
     @endif

      @if(!empty($social))
      <div class="foot-social">
        @foreach($social as $net => $url)
          @continue(empty($url))
          <a class="foot-social-btn"
             href="{{ \Illuminate\Support\Str::startsWith($url, ['http://','https://']) ? $url : 'https://'.$url }}"
             target="_blank" rel="noopener" aria-label="{{ ucfirst($net) }}">
            <i class="fa-brands fa-{{ strtolower($net) }}"></i>
          </a>
        @endforeach
      </div>
      @endif
    </div>

  </div>
</footer>

<style>
.site-footer{ background:#2B9E3C; color:#fff; padding:48px 0; }
.footer-grid{ display:grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap:32px; }
@media (max-width:1100px){ .footer-grid{ grid-template-columns: 1fr 1fr; } }
@media (max-width:700px){ .footer-grid{ grid-template-columns: 1fr; } }
.foot-col{ min-width:0; }
.foot-logo{ max-width: 220px; height:auto; display:block; }
.foot-title{ margin:0 0 12px; font-size:28px; font-weight:800; }
.foot-links{ list-style:none; margin:0; padding:0; }
.foot-links li{ margin:8px 0; }
.foot-links a{ color:#fff; text-decoration:none; }
.foot-links a:hover{ text-decoration:underline; }
.foot-line{ display:flex; gap:10px; align-items:flex-start; margin:10px 0; }
.foot-line a{ color:#fff; text-decoration:none; }
.foot-line i{ width:18px; line-height:1.2; margin-top:2px; }
.foot-social{ display:flex; gap:12px; margin-top:12px; }
.foot-social-btn{ width:40px; height:40px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; background:rgba(255,255,255,.15); color:#fff; }
.foot-social-btn:hover{ background:rgba(255,255,255,.25); }
</style>

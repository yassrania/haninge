{{-- resources/views/partials/footer.blade.php --}}
@php
    use App\Models\FooterSetting;
    use App\Models\FooterLinkGroup;
    $footer = FooterSetting::first();
    $groups = FooterLinkGroup::with('links')->orderBy('sort')->get();
@endphp

<footer id="contact" class="site-footer">
  <div class="container footer-inner">
    <div class="footer-brand">
      @if($footer?->brand_logo)
        <img src="{{ asset('storage/'.$footer->brand_logo) }}" alt="{{ $footer->brand_alt }}" />
      @endif
      @if($footer?->brand_text)
        <p>{{ $footer->brand_text }}</p>
      @endif
    </div>

    @foreach($groups as $group)
      <div class="footer-col">
        <h4>{{ $group->title }}</h4>
        <ul>
          @foreach($group->links as $link)
            <li>
              <a href="{{ $link->url }}" @if($link->is_external) target="_blank" rel="noopener" @endif>{{ $link->label }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach

    <!--<div class="footer-col">
      <h4>Öppettider</h4>
      <ul>
        @foreach(($footer->opening_hours ?? []) as $row)
          <li>{{ $row['label'] ?? '' }}: {{ $row['value'] ?? '' }}</li>
        @endforeach
      </ul>
    </div>
//-->
    <div class="footer-col">
      <h4>Kontaktuppgifter</h4>
      <ul class="contact-list">
        @if($footer?->address)<li>Adress: {{ $footer->address }}</li>@endif
        @if($footer?->phone)<li>Telefon: {{ $footer->phone }}</li>@endif
        @if($footer?->email)<li>E-post: {{ $footer->email }}</li>@endif
      </ul>
      @if(!empty($footer?->social_links))
        <div class="socials">
          @foreach($footer->social_links as $s)
            <a href="{{ $s['url'] ?? '#' }}" target="_blank" rel="noopener">{{ $s['platform'] ?? 'Social' }}</a>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <p>{{ $footer->bottom_text ?? ('© '.date('Y').' Haninge Islamiska Forum. Alla rättigheter förbehållna.') }}</p>
    </div>
  </div>
</footer>

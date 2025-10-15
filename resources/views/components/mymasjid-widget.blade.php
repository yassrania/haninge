@props([
  'guid',
  // widget = أوقات فقط (بدون ساعة) | screen = شاشة كاملة
  'variant' => 'widget',
  'height' => '420px',
  'title' => null,
  // إن كان bare=true → بدون بطاقة/خلفية نهائياً
  'bare' => false,
  'rounded' => true,
  'shadow' => true,
])

@php
  $base = $variant === 'screen' ? 'timingscreen' : 'widget';
@endphp

@if($bare)
  {{-- وضع شفاف تماماً (لا خلفية ولا حدود) --}}
  @if($title)
    <div class="mb-2" style="background:transparent;color:inherit;">{{ $title }}</div>
  @endif
  <div style="max-width:100%; overflow:hidden; background:transparent;">
    <iframe
      src="https://time.my-masjid.com/{{ $base }}/{{ $guid }}"
      title="Prayer Times – My Masjid"
      loading="lazy"
      style="display:block; width:100%; height:{{ $height }}; border:0; background:transparent;"
      referrerpolicy="no-referrer"
    ></iframe>
  </div>
@else
  {{-- النسخة العادية (ببطاقة اختيارية) --}}
  @php
    $roundedCls = $rounded ? 'rounded-4' : '';
    $shadowCls  = $shadow  ? 'shadow-sm'  : '';
  @endphp
  <div class="mymasjid-widget card border-0 {{ $roundedCls }} {{ $shadowCls }}">
    @if($title)
      <div class="card-header bg-white py-2 px-3">
        <strong class="small">{{ $title }}</strong>
      </div>
    @endif
    <div class="card-body p-0" style="height: {{ $height }};">
      <iframe
        src="https://time.my-masjid.com/{{ $base }}/{{ $guid }}"
        title="Prayer Times – My Masjid"
        loading="lazy"
        style="display:block; width:100%; height:100%; border:0;"
        referrerpolicy="no-referrer"
      ></iframe>
    </div>
  </div>
@endif

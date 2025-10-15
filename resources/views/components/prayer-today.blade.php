@props(['item' => null])

@php
$labels = ['Fajr'=>'الفجر','Dhuhr'=>'الظهر','Asr'=>'العصر','Maghrib'=>'المغرب','Isha'=>'العشاء'];
@endphp

<div class="prayer-today d-grid" style="grid-template-columns: repeat(5, minmax(0,1fr)); gap:.5rem;">
  @foreach($labels as $k=>$label)
    <div class="p-2 border rounded text-center">
      <div class="small text-muted">{{ $label }}</div>
      <div class="fw-bold">{{ $item?->$k ? $item->$k : '--:--' }}</div>
    </div>
  @endforeach
</div>

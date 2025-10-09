{{-- resources/views/services/show.blade.php --}}
@extends('layouts.app')

@section('title', ($service->title ?? 'Tjänst') . ' — Haninge Islamiska Forum')

@section('content')

@php
    // Banner
    $banner = $service->page_banner
        ? asset('storage/'.$service->page_banner)
        : asset('assets/img/om-islam-banner.jpg');

    // Builder blocks (Innehåll)
    $blocks = is_array($service->blocks ?? null) ? $service->blocks : [];
    $formFields = is_array($service->form_fields ?? null) ? $service->form_fields : [];


    // Fallback: Prayer fields (لو ما فيه blocks)
    $prImg      = $service->prayer_image    ? asset('storage/'.$service->prayer_image) : null;
    $prTitle    = $service->prayer_title    ?? null;
    $prSubtitle = $service->prayer_subtitle ?? null;
    $prArticle  = $service->prayer_article  ?? null;

    // Donera (لا تظهر إلا عند وجود بيانات)
    $qrImg   = $service->donate_qr_image ? asset('storage/'.$service->donate_qr_image) : null;
    $dTitle  = $service->donate_title    ?? null;
    $dSub    = $service->donate_subtitle ?? null;
    $dBody   = $service->donate_article  ?? null;
    $dBtnTxt = $service->donate_btn_text ?? null;
    $dBtnUrl = $service->donate_btn_url  ?? null;

    $hasDonate = $qrImg || $dTitle || $dSub || $dBody || ($dBtnTxt && $dBtnUrl);
@endphp

<!-- ===== Banner (نفس الكلاسات) ===== -->
<section class="page-banner" style="background-image:url('{{ $banner }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>{{ $service->title ?? 'Tjänst' }}</h1>
    @if(!empty($service->subtitle))
      <p>{{ $service->subtitle }}</p>
    @endif
  </div>
</section>

<main>

  {{-- ===== Innehåll (Builder) إن وُجد ===== --}}
  @if(count($blocks))
    @foreach($blocks as $block)
      @php
        $type = $block['type'] ?? null;
        $data = $block['data'] ?? [];
      @endphp

      {{-- عنوان قسم --}}
      @if($type === 'section_title')
        <section class="section">
          <div class="container prayer-grid">
            <div class="prayer-text">
            @if(!empty($data['title']))    <h2 class="green">{{ $data['title'] }}</h2> @endif
            @if(!empty($data['subtitle'])) <h6 class="orange">{{ $data['subtitle'] }}</h6> @endif
          </div>
        </section>
      @endif

      {{-- نص غني --}}
      @if($type === 'rich_text')
        <section class="section">
          <div class="container">
            <p> class="text">{!! $data['content'] ?? '' !!}</p>
</div>
          </div>
        </section>
      @endif

      {{-- صورة + نص (نفس بنية boner-och-gudsdyrkan) --}}
      @if($type === 'image_with_text')
  @php
    $img = !empty($data['image']) ? asset('storage/'.$data['image']) : null;

    $posRaw = strtolower(trim($data['image_position'] ?? 'left'));
    // ندعم كتابات متعددة:
    $pos = in_array($posRaw, ['right','höger','hoger']) ? 'right' : 'left';
  @endphp
         <section class="section">
    <div class="container prayer-grid {{ $pos === 'right' ? 'img-right' : 'img-left' }}">
      <figure class="prayer-frame frame">
        @if($img)
          <img src="{{ $img }}" alt="{{ $data['title'] ?? '' }}">
        @endif
      </figure>

      <div class="prayer-text">
        @if(!empty($data['title'])) <h2 class="green">{{ $data['title'] }}</h2> @endif
        @if(!empty($data['text']))  <div class="text">{!! nl2br(e($data['text'])) !!}</div> @endif
      </div>
    </div>
  </section>
@endif
    @endforeach

  {{-- وإلا استخدم حقول Prayer التقليدية --}}
  @elseif($prImg || $prTitle || $prSubtitle || $prArticle)
    <section class="section">
      <div class="container prayer-grid">
        <figure class="prayer-frame frame">
          @if($prImg)
            <img src="{{ $prImg }}" alt="{{ $prTitle ?? 'Bön i moskén' }}">
          @endif
        </figure>
        <div class="prayer-text">
          @if($prTitle)    <h2 class="green">{{ $prTitle }}</h2>      @endif
          @if($prSubtitle) <h6 class="orange">{{ $prSubtitle }}</h6>  @endif
          @if($prArticle)  <div class="text">{!! $prArticle !!}</div> @endif
        </div>
      </div>
    </section>
  @endif
<!-- ===== Form (نفس الكلاسات) ===== -->
@if(count($formFields))
<section class="vigsel-wrap">
  <div class="vigsel-card">
    <h2 class="vigsel-title">{{ $service->form_title ?? ($service->title.' – Formulär') }}</h2>

    @php
      // تجميع حسب المجموعة (الخطوة)، مع ترتيب داخلي
      $groups = collect($formFields)
        ->sortBy(fn($f) => $f['order'] ?? 0)
        ->groupBy(fn($f) => trim($f['group'] ?? 'Steg'));
      $groupLabels = $groups->keys()->values()->all();
    @endphp

    {{-- شريط الخطوات --}}
    <ol class="vigsel-steps" role="tablist" aria-label="Steg">
      @foreach($groupLabels as $i => $g)
        <li class="{{ $i===0 ? 'is-active' : '' }}" data-step="{{ $i+1 }}">
          <span class="pill">{{ $i+1 }}</span>
          <span class="lbl">{{ strtoupper($g) }}</span>
        </li>
      @endforeach
    </ol>

    {{-- الفورم --}}
    <form id="dynWizardForm" action="{{ route('service.form.submit', $service->slug) }}" method="post" enctype="multipart/form-data" novalidate>
      @csrf

      @foreach($groups as $idx => $fields)
        <fieldset class="wizard-step" data-step="{{ $loop->iteration }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}" style="{{ $loop->first ? '' : 'display:none' }}">
          <legend>{{ $idx }}</legend>

          {{-- شبكة مرنة: نحول width إلى كلاسات --}}
          <div class="wizard-grid">
          @foreach($fields as $f)
            @php
              $type  = $f['type'] ?? 'text';
              $name  = $f['name'] ?? ('field_'.uniqid());
              $label = $f['label'] ?? ucfirst($name);
              $req   = !empty($f['required']);
              $ph    = $f['placeholder'] ?? '';
              $help  = $f['help'] ?? '';
              $opts  = array_filter(array_map('trim', explode(',', $f['options'] ?? '')));
              $w     = $f['width'] ?? '1/3';
              $wCls  = $w==='1' ? 'col-1' : ($w==='1/2' ? 'col-1-2' : 'col-1-3');
            @endphp
               @if($type === 'description')
    <div class="frow col-1">
      <div class="form-description">
        {!! $f['content'] ?? '' !!}
      </div>
    </div>
    @continue
  @endif
            <div class="frow {{ $wCls }}">
              {{-- checkbox له تنسيق مختلف --}}
              @if($type === 'checkbox')
                <label class="checkbox">
                  <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="1" {{ old($name) ? 'checked' : '' }} {{ $req ? 'required' : '' }}>
                  <span>{{ $label }} @if($req)<span class="req">*</span>@endif</span>
                </label>
                @if($help)<small class="help">{{ $help }}</small>@endif
                @error($name)<div class="error">{{ $message }}</div>@enderror
              @else
                <label for="{{ $name }}">{{ $label }} @if($req)<span class="req">*</span>@endif</label>

                @if($type === 'textarea')
                  <textarea id="{{ $name }}" name="{{ $name }}" rows="4" placeholder="{{ $ph }}" {{ $req ? 'required' : '' }}>{{ old($name) }}</textarea>

                @elseif($type === 'select')
                  <select id="{{ $name }}" name="{{ $name }}" {{ $req ? 'required' : '' }}>
                    <option value="" disabled selected>{{ $ph ?: 'Välj…' }}</option>
                    @foreach($opts as $op)<option value="{{ $op }}">{{ $op }}</option>@endforeach
                  </select>

                @elseif($type === 'file')
                  <input type="file" id="{{ $name }}" name="{{ $name }}" {{ $req ? 'required' : '' }}>

                @else
                  {{-- text / email / tel / date / time --}}
                  <input type="{{ in_array($type,['text','email','tel','date','time']) ? $type : 'text' }}"
                         id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}"
                         placeholder="{{ $ph }}" {{ $req ? 'required' : '' }}>
                @endif

                @if($help)<small class="help">{{ $help }}</small>@endif
                @error($name)<div class="error">{{ $message }}</div>@enderror
              @endif
            </div>
          @endforeach
          </div>

          <div class="wizard-actions {{ $loop->first ? '' : ($loop->last ? 'between' : 'between') }}">
            @if(!$loop->first)
              <button type="button" class="btn-prev">Tillbaka</button>
            @endif
            @if(!$loop->last)
              <button type="button" class="btn-next">Nästa</button>
            @else
              <button type="submit" class="btn-submit">Skicka</button>
            @endif
          </div>
        </fieldset>
      @endforeach
      <script>
document.getElementById('dynWizardForm')?.addEventListener('submit', function () {
  this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
});
</script>

    </form>
  </div>
</section>
<script>
(function(){
  const form  = document.getElementById('dynWizardForm');
  if(!form) return;
  const steps = Array.from(document.querySelectorAll('.wizard-step'));
  const tabs  = Array.from(document.querySelectorAll('.vigsel-steps li'));
  let idx = 0;

  function show(i){
    steps.forEach((s,k)=>{
      const on = k===i;
      s.style.display = on ? '' : 'none';
      s.setAttribute('aria-hidden', on ? 'false' : 'true');
    });
    tabs.forEach((t,k)=> t.classList.toggle('is-active', k===i));
    idx = i;
    window.scrollTo({ top: form.closest('.vigsel-wrap').offsetTop - 40, behavior: 'smooth' });
  }
  function next(){ if(idx < steps.length-1) show(idx+1); }
  function prev(){ if(idx > 0) show(idx-1); }

  form.addEventListener('click', (e)=>{
    if(e.target.matches('.btn-next')){ e.preventDefault(); next(); }
    if(e.target.matches('.btn-prev')){ e.preventDefault(); prev(); }
  });

  show(0);
})();
</script>
@endif

  {{-- شريط أخضر كما في الصفحة الأصلية --}}
  <section class="prayer-band" aria-hidden="true"></section>

  {{-- ===== Donera (شرطي) ===== --}}
  @if($hasDonate)
  <section class="donate-card">
    <div class="container">
      <div class="donate-box">

        <figure class="donate-qr">
          @if($qrImg)
            <img src="{{ $qrImg }}" alt="Swish – Stöd Alby moské">
          @endif
        </figure>

        <div class="donate-text">
          @if($dTitle)  <h2 class="green">{{ $dTitle }}</h2> @endif
          @if($dSub)    <h5 class="deep">{{ $dSub }}</h5>   @endif
          @if($dBody)   <div class="text">{!! $dBody !!}</div> @endif

          @if($dBtnTxt && $dBtnUrl)
            <a href="{{ $dBtnUrl }}" class="btn-orange">{{ $dBtnTxt }}</a>
          @endif
        </div>

      </div>
    </div>
  </section>
  @endif

</main>
@endsection

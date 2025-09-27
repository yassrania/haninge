@extends('layouts.app')

@section('title','Om Islam — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner Om Islam ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Om Islam</h1>
    <p>En introduktion</p>
  </div>
</section>

<main class="site-main">

  <!-- Den muslimska tron -->
  <section class="section about-grid">
    <div class="container grid-2">
      <figure class="frame">
        <img src="{{ asset('assets/img/islam-1.jpg') }}" alt="Den muslimska tron">
      </figure>
      <div>
        <h2 class="green">Den muslimska tron</h2>
        <p>Text om muslimska tron...</p>
      </div>
    </div>
  </section>

  <!-- Dykan i Islam -->
  <section class="section about-grid">
    <div class="container grid-2">
      <div>
        <h2 class="green">Dykan i Islam</h2>
        <p>Text om dykan...</p>
      </div>
      <figure class="frame">
        <img src="{{ asset('assets/img/islam-2.jpg') }}" alt="Dykan i Islam">
      </figure>
    </div>
  </section>

  <!-- Om Profeten Mohammad -->
  <section class="section section-green">
    <div class="container text-center">
      <h2 class="white">Om Profeten Mohammad</h2>
      <p class="white">Kort presentation i två kolumner...</p>
      <blockquote class="islam-quote">"Citat från Profeten" — Källa</blockquote>
    </div>
  </section>

  <!-- Vad tror muslimer? -->
  <section class="section">
    <div class="container">
      <h2 class="green">Vad tror muslimer?</h2>
      <p>Lång text ...</p>
    </div>
  </section>

  <!-- Islamisk monoteism -->
  <section class="section about-grid">
    <div class="container grid-2">
      <div>
        <h2 class="green">Islamisk monoteism</h2>
        <p>Text...</p>
      </div>
      <figure>
        <img src="{{ asset('assets/img/islam-3.jpg') }}" alt="Islamisk monoteism">
      </figure>
    </div>
  </section>

  <!-- Vilka är muslimerna -->
  <section class="section about-grid">
    <div class="container grid-2">
      <figure class="frame">
        <img src="{{ asset('assets/img/islam-4.jpg') }}" alt="Vilka är muslimerna">
      </figure>
      <div>
        <h2 class="green">Vilka är muslimerna</h2>
        <p>Text...</p>
      </div>
    </div>
  </section>

  <!-- Islams referenskällor -->
  <section class="section about-grid">
    <div class="container grid-2">
      <div>
        <h2 class="green">Islams referenskällor</h2>
        <p>Text...</p>
      </div>
      <figure>
        <img src="{{ asset('assets/img/islam-5.jpg') }}" alt="Islams referenskällor">
      </figure>
    </div>
  </section>

</main>

@endsection

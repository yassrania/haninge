@extends('layouts.app')

@section('title','Om moskén — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Om moskén</h1>
    <p>Islamiskt Forum i Botkyrka sedan 1992</p>
  </div>
</section>

<main class="site-main">

  <!-- Haninge moskén -->
  <section class="section about-grid">
    <div class="container grid-2">
      <figure class="frame">
        <img src="{{ asset('assets/img/mosken-1.jpg') }}" alt="Haninge moskén">
      </figure>
      <div>
        <h2 class="green">Haninge moskén</h2>
        <h4 class="orange">Islamiskt Forum i Botkyrka</h4>
        <p>Text om moskéns historia och arbete...</p>
      </div>
    </div>
  </section>

  <!-- Vårt mål och syfte -->
  <section class="section about-grid">
    <div class="container grid-2">
      <div>
        <h2 class="green">Vårt mål och syfte</h2>
        <h4 class="orange">Integration och engagemang</h4>
        <ul class="check-list">
          <li>Stödja Sveriges muslimer...</li>
          <li>Öka deltagandet och representationen...</li>
          <li>Stärka kontakten med andra muslimska aktörer...</li>
          <li>Delta aktivt i kampen för mänskliga rättigheter...</li>
        </ul>
      </div>
      <figure class="frame">
        <img src="{{ asset('assets/img/mosken-2.jpg') }}" alt="Vårt mål och syfte">
      </figure>
    </div>
  </section>

  <!-- En plats för dig (CTA med bakgrund) -->
  <section class="cta-bg" style="background-image:url('{{ asset('assets/img/cta-mosken.jpg') }}')">
    <div class="cta-overlay"></div>
    <div class="container cta-inner">
      <h2>En plats för dig</h2>
      <p>
        Vårt islamiska centrum är stolt över sitt arv av mångfald, öppenhet och samhällsengagemang.
        Bli en del av oss på Haninge moskén, bli medlem!
      </p>
      <a class="cta-btn" href="{{ route('stod-mosken') }}">Läs mer om medlemskap</a>
    </div>
  </section>

  <!-- Stöd moskén -->
  <section class="section">
    <div class="container support-box">
      <div class="support-card">
        <div class="qr">
          <img src="{{ asset('assets/img/swish-qr.png') }}" alt="Swish QR code">
          <p class="muted">123-277 16 24</p>
        </div>
        <div class="support-text">
          <h2 class="green">Stöd Haninge moskén</h2>
          <h4 class="orange">Ditt stöd är nödvändigt för att vi ska kunna fortsätta vårt arbete</h4>
          <p>Text om varför stöd är viktigt...</p>
          <a class="btn-orange" href="{{ route('stod-mosken') }}">Läs mer och hjälp till</a>
        </div>
      </div>
    </div>
  </section>

</main>

@endsection

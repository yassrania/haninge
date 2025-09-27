@extends('layouts.app')

@section('title','Stöd moskén — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Stöd Haninge moskén</h1>
    <p>Ditt stöd är nödvändigt för att vi ska kunna fortsätta vårt arbete</p>
  </div>
</section>

<main class="site-main">
  <!-- Content grid -->
  <section class="section section-tight">
    <div class="container support-wrap">
      <!-- Bild -->
      <figure class="support-photo">
        <img src="{{ asset('assets/img/stod-moske.jpg') }}" alt="Donation / Zakat">
      </figure>

      <!-- Sidokolumn (donation info) -->
      <aside class="support-aside tight-top">
        <h3>Bli medlem och ge din moskéavgift idag!</h3>
        <p>
          Om du vill stödja din lokala moské behöver du skicka in ett skriftligt medgivande.
        </p>
        <ul class="support-list">
          <li>Medgivandet gäller för hela kalenderåret</li>
          <li>Medlemsavgiften ligger för närvarande på 1%</li>
          <li>Beräkningen: 100 000 kr → 83 kr/månad</li>
          <li>200 000 kr → 167 kr/månad</li>
          <li>300 000 kr → 250 kr/månad</li>
        </ul>
        <a href="#" class="btn-orange">Ladda ned och fyll i blanketten</a>
        <div class="qr">
          <img src="{{ asset('assets/img/swish-qr.png') }}" alt="Swish QR code">
          <p class="muted">123 277 16 24</p>
        </div>
      </aside>
    </div>

    <!-- Text under -->
    <div class="container support-text">
      <h2 class="green">Vi uppskattar ditt stöd!</h2>
      <h4 class="orange">Donera till Haninge Moské</h4>
      <p>
        Haninge moskén arbetar för att vi och våra barn ska ha en trygg plats för bön,
        utbildning och gemenskap. Ditt stöd gör att vi kan fortsätta utveckla verksamheten.
      </p>

      <h2 class="green">Ditt bidrag gör skillnad!</h2>
      <h4 class="orange">Du kan bidra på olika sätt</h4>
      <p>Moskéns organisationsnummer är <strong>815601-0947</strong>.</p>
      <p><strong>Swish:</strong> 123 277 16 24</p>
      <p><strong>Bankgiro:</strong> 5233-5916</p>
    </div>
  </section>
</main>

@endsection

@extends('layouts.app')

@section('title','Böner och gudsdyrkan — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Böner och gudsdyrkan</h1>
    <p>Öppet under alla bönetider, fem gånger om dagen</p>
  </div>
</section>

<main>
  <!-- Intro -->
  <section class="section">
    <div class="container prayer-grid">
      <figure class="prayer-frame frame">
        <img src="{{ asset('assets/img/services-prayer-big.jpg') }}" alt="Bön i moskén">
      </figure>

      <div class="prayer-text">
        <h2 class="green">En av våra fem pelare</h2>
        <h6 class="orange">MOSKÉN ÄR ÖPPEN UNDER ALLA BÖNETIDER</h6>
        <p>
          Bönen är en av islams fem pelare vilket gör att många muslimer vänder sig
          till bön i Haninge moské. Moskéen är öppen under alla bönetider, fem gånger om dagen,
          och tiden för varje bön är ca 10 minuter.
        </p>

        <h6 class="orange">FREDAGSPREDIKAN</h6>
        <p>
          Fredagsbönen är muslimernas veckoceremoni och brukar sträcka sig till normalt
          ca 30 minuter. Denna ritual består av en fredagspredikan på arabiska och en
          översättning till svenska samt en bön.
        </p>
        <p>
          Bönetiderna för fredagsritualen äger rum kl. 12:00 vintertid och kl. 13:00
          sommartid.
        </p>
        <p>
          Fredagspredikan är ett medel för moskén att förmedla sitt budskap till familjerna
          och samhället, genom att uppmärksamma de viktiga samhällsproblemen och
          erbjuda lösningar till dem, både ett religiöst perspektiv men också från ett
          samhällssyntigt perspektiv som överensstämmer med Sveriges regler och lagar.
        </p>
      </div>
    </div>
  </section>

  <!-- green band -->
  <section class="prayer-band" aria-hidden="true"></section>

  <!-- Stöd box -->
  <section class="donate-card">
    <div class="container">
      <div class="donate-box">
        <!-- Swish QR -->
        <figure class="donate-qr">
          <img src="{{ asset('assets/img/stod-switsh.jpg') }}" alt="Swish – Stöd Haninge moské">
        </figure>

        <!-- Text -->
        <div class="donate-text">
          <h2 class="green">Stöd Haninge moskén</h2>
          <h5 class="deep">Ditt stöd är nödvändigt för att vi ska kunna fortsätta vårt arbete</h5>

          <p>
            Haninge moskén arbetar för att vi och våra barn ska ha en plats för att praktisera vår
            religion och utföra våra riter.
          </p>
          <p>
            Moskén har en driftskostnad och håller många aktiviteter och program. Moskén
            samarbetar också med flera välgörenhetsorganisationer, för att stötta de fattiga
            och behövande. Genom att bidra till moskén hjälper du att säkra driftskostnaderna
            och fortsättningen av moskéns aktiviteter.
          </p>

          <a href="{{ route('stod-mosken') }}" class="btn-orange">Läs mer och hjälp till</a>
        </div>
      </div>
    </div>
  </section>
</main>

@endsection

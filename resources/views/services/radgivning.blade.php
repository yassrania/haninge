@extends('layouts.app')

@section('title','Rådgivning — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Rådgivning</h1>
    <p>Personlig och juridisk rådgivning</p>
  </div>
</section>

<main>
  <!-- Intro -->
  <section class="section intro-grid">
    <figure class="framed">
      <img src="{{ asset('assets/img/radgivning.jpg') }}" alt="Rådgivning i moskén">
    </figure>

    <div>
      <h2 class="green">Personlig och juridisk rådgivning</h2>
      <p>
        Haninge moskén erbjuder både personlig och juridisk rådgivning. Vi är en resurs
        för dig och din familj och kan bistå i frågor som rör sociala relationer,
        familjesituationer och enklare juridiska spörsmål.
      </p>
      <p>
        Kontakta oss för att boka ett samtal. All rådgivning sker konfidentiellt och
        med respekt för individens integritet.
      </p>
      <a class="btn-outline" href="{{ route('kontakt') }}">Boka tid via kontaktformuläret</a>
    </div>
  </section>

  <!-- Donate box -->
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

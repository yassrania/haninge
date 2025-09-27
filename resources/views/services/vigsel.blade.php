@extends('layouts.app')

@section('title','Vigsel i enlighet med Islam — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Vigselförrättning</h1>
    <p>Vigsel i enlighet med Islam</p>
  </div>
</section>

<main>
  <!-- Intro -->
  <section class="section">
    <div class="container sr-grid">
      <figure class="sr-media frame">
        <img src="{{ asset('assets/img/Vigsel-i-enlighet-med-Islam.jpg') }}" alt="Vigsel i moskén">
      </figure>

      <div class="sr-text">
        <h2 class="green">Vigsel i enlighet med Islam</h2>
        <h6 class="orange">FÖRENAS INFÖR ALLAH</h6>
        <p>
          Haninge moskén erbjuder möjligheten att viga sig i enlighet med Islam.
          För att viga sig i Haninge moskén så behövs ett
          <a href="https://www.skatteverket.se" target="_blank" rel="noopener">hindersprövningsintyg</a>
          från Skatteverket och giltiga id-handlingar.
        </p>
        <p>
          Själva ceremonin tar ca 30 minuter. För bokningsförfrågan, vänligen fyll i nedan
          formulär och skicka in till oss.
        </p>
      </div>
    </div>
  </section>

  <!-- Formulär -->
  <section class="form-banner">
    <div class="container nikah-form">
      <h2 class="form-title">Ansök om vigsel i enlighet med Islam</h2>

      <div class="form-steps" aria-hidden="true">
        <div class="step"><span>1</span> <small>MAKE</small></div>
        <div class="step"><span>2</span> <small>MAKA</small></div>
        <div class="step"><span>3</span> <small>DATUM</small></div>
      </div>

      <form action="#" method="post" class="form-grid" autocomplete="off">
        @csrf
        <div class="field">
          <label>Förnamn</label>
          <input type="text" required>
        </div>
        <div class="field">
          <label>Efternamn</label>
          <input type="text" required>
        </div>
        <div class="field">
          <label>Personnummer</label>
          <input type="text" placeholder="ÅÅMMDDXXXX" required>
        </div>
        <div class="field">
          <label>E-postadress</label>
          <input type="email" required>
        </div>
        <div class="field">
          <label>Telefonnummer</label>
          <input type="tel" required>
        </div>
        <div class="field">
          <label>Adress</label>
          <input type="text" required>
        </div>
        <div class="field">
          <label>Postnummer</label>
          <input type="text" required>
        </div>
        <div class="field">
          <label>Ort</label>
          <input type="text" required>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-orange">Nästa</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Donate box -->
  <section class="donate-card">
    <div class="container">
      <div class="donate-box">
        <figure class="donate-qr">
          <img src="{{ asset('assets/img/stod-switsh.jpg') }}" alt="Swish – Stöd Haninge moské">
        </figure>
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

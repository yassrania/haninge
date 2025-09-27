@extends('layouts.app')

@section('title','Utbildning — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Utbildning</h1>
    <p>Lär dig mer om Islam och det arabiska språket</p>
  </div>
</section>

<main class="site-main">
  <div class="container">
    <!-- ===== Vuxna ===== -->
    <section class="section intro-grid">
      <figure class="framed">
        <img src="{{ asset('assets/img/utb-vuxna.jpg') }}" alt="Utbildning för vuxna">
      </figure>
      <div>
        <h2 class="green">Utbildningsprogram för vuxna</h2>
        <p>
          Vill du lära dig mer om Islam och Koranen samt om den arabiska kulturen?
          Ansök till Haninge moskéns utbildningsprogram för vuxna redan idag.
        </p>
      </div>
    </section>

    <!-- Form vuxna -->
    <section class="form-banner">
      <div class="container utb-form">
        <h2 class="form-title">Ansökan till utbildningsprogram för vuxna</h2>
        <form class="form-grid" action="#" method="post" autocomplete="off">
        @csrf
          <div class="field"><label>Förnamn *</label><input type="text" required></div>
          <div class="field"><label>Efternamn *</label><input type="text" required></div>
          <div class="field"><label>Personnummer *</label><input type="text" placeholder="ÅÅMMDDXXXX" required></div>
          <div class="field"><label>Postadress</label><input type="text"></div>
          <div class="field"><label>Postnummer</label><input type="text"></div>
          <div class="field"><label>Ort</label><input type="text"></div>
          <div class="field"><label>E-postadress *</label><input type="email" required></div>
          <div class="field"><label>Telefonnummer</label><input type="tel"></div>
          <div class="field"><label>Önskad kurs</label><input type="text" placeholder="Ex. Arabiska nybörjare"></div>
          <div class="consent">
            <label><input type="checkbox" required> Jag godkänner att mina personuppgifter behandlas enligt Haninge moskéns Integritetspolicy.</label>
          </div>
          <div class="form-actions"><button class="btn-orange" type="submit">Skicka</button></div>
        </form>
      </div>
    </section>

    <!-- ===== Barn ===== -->
    <section class="section intro-grid alt">
      <div>
        <h2 class="green">Utbildningsprogram för barn</h2>
        <p>
          Låt ditt barn lära sig om Islam och Koranen, den arabiska kulturen och att tala
          och skriva på arabiska eller få hjälp med läxor. Anmäl ditt barn idag.
        </p>
      </div>
      <figure class="framed">
        <img src="{{ asset('assets/img/utb-barn.jpg') }}" alt="Utbildning för barn">
      </figure>
    </section>

    <!-- Form barn -->
    <section class="form-banner">
      <div class="container kids-form">
        <h2 class="form-title green text-center">Ansökan till utbildningsprogram för barn</h2>
        <p class="text-center">
          Ansökan till utbildningsprogram för barn i Haninge Moské!<br>
          Fyll i formuläret nedan för att registrera ditt barn. Observera att antalet platser är begränsat.<br>
          Koranskolan är kostnadsfri för medlemmar.<br>
          Medlemsavgift per familj: 1000 kr / år.
        </p>

        <form id="kidsApplication" class="form-grid kids-grid" action="#" method="post">
          <div class="field"><label>Barnets namn *</label><input type="text" required></div>
          <div class="field"><label>Personnummer *</label><input type="text" placeholder="ÅÅMMDDXXXX" required></div>
          <div class="field">
            <label>Kön *</label>
            <div class="radio-row">
              <label><input type="radio" name="gender" value="Pojke" required> Pojke</label>
              <label><input type="radio" name="gender" value="Flicka" required> Flicka</label>
            </div>
          </div>
          <div class="field"><label>Telefonnummer till vårdnadshavare *</label><input type="tel" required></div>
          <div class="field"><label>Adress *</label><input type="text" required></div>
          <div class="field"><label>Postnummer *</label><input type="text" required></div>
          <div class="field"><label>Ort *</label><input type="text" required></div>
          <div class="field"><label>Modersmål *</label>
            <div class="radio-col">
              <label><input type="radio" name="lang" value="Svenska" required> Svenska</label>
              <label><input type="radio" name="lang" value="Arabiska" required> Arabiska</label>
              <label><input type="radio" name="lang" value="Engelska" required> Engelska</label>
              <label><input type="radio" name="lang" value="Other" required> Övrigt</label>
              <input type="text" placeholder="Ange språk…">
            </div>
          </div>
          <div class="field field-full"><label>Något mer vi bör känna till?</label><textarea rows="4"></textarea></div>
          <div class="field field-full terms-box">
            <p><strong>Villkor för deltagande:</strong> Om barnet inte lämnar in läxor eller är frånvarande utan anmälan i tre veckor kan platsen förloras.</p>
            <label><input type="checkbox" required> Jag har läst och godkänner villkoren.</label>
          </div>
          <div class="form-actions"><button type="submit" class="btn-orange">Skicka</button></div>
        </form>
      </div>
    </section>

    <!-- Stöd moskén -->
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
              Haninge moskén arbetar för att vi och våra barn ska ha en plats för att praktisera vår religion
              och utföra våra riter.
            </p>
            <p>
              Moskén har en driftskostnad och håller många aktiviteter och program.
              Genom att bidra till moskén hjälper du att säkra driftskostnaderna och fortsättningen av verksamheten.
            </p>
            <a href="{{ route('stod-mosken') }}" class="btn-orange">Läs mer och hjälp till</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

@endsection

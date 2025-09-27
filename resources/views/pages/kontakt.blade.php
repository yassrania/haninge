@extends('layouts.app')

@section('title','Kontakta oss — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Kontakta oss</h1>
    <p>Vi svarar gärna på era frågor eller funderingar</p>
  </div>
</section>

<main class="site-main">
  <!-- Intro -->
  <section class="section text-center">
    <div class="container">
      <h5 class="orange">Skriv till oss</h5>
      <h2 class="green">Kom i kontakt med oss</h2>
      <p>
        Har du frågor om våra program eller tjänster? Vill du veta mer om Islam?
        Använd vårt kontaktformulär så återkopplar vi till dig så snart som möjligt.
      </p>
    </div>
  </section>

  <!-- Form -->
  <section class="section">
    <div class="container contact-box">
      <form class="contact-form" action="#" method="post">
        @csrf
        <div class="form-grid">
          <div class="form-group">
            <label for="namn">Ditt namn *</label>
            <input type="text" id="namn" name="namn" required>
          </div>
          <div class="form-group">
            <label for="email">Din e-postadress *</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="telefon">Ditt telefonnummer</label>
            <input type="tel" id="telefon" name="telefon">
          </div>
          <div class="form-group">
            <label for="amne">Ämne</label>
            <input type="text" id="amne" name="amne">
          </div>
        </div>
        <div class="form-group full">
          <label for="meddelande">Ditt meddelande *</label>
          <textarea id="meddelande" name="meddelande" rows="6" required></textarea>
        </div>
        <div class="form-check">
          <input type="checkbox" id="gdpr" required>
          <label for="gdpr">
            Jag godkänner att mina personuppgifter behandlas enligt GDPR samt
            enligt Haninge Islamiska Forums Integritetspolicy.
          </label>
        </div>
        <button type="submit" class="btn-orange">Skicka</button>
      </form>
    </div>
  </section>

  <!-- Contact info -->
  <section class="section contact-info">
    <div class="container info-grid">
      <div class="info-item">
        <div class="icon">📞</div>
        <h4>Telefonnummer</h4>
        <p>072-001 05 68</p>
      </div>
      <div class="info-item">
        <div class="icon">✉️</div>
        <h4>E-postadress</h4>
        <p>kontakt@haningeislamiskaforum.se</p>
      </div>
      <div class="info-item">
        <div class="icon">📍</div>
        <h4>Adress</h4>
        <p>Rotemannavägen 24, 145 57 Norsborg</p>
      </div>
    </div>
  </section>
</main>

@endsection

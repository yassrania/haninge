@extends('layouts.app')

@section('title','Kontakta oss — Haninge Islamiska Forum')

@section('content')

<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Kontakta oss</h1>
    <p>Vi svarar gärna på era frågor eller funderingar</p>
  </div>
</section>

<main class="site-main">
  <section class="section text-center">
    <div class="container">
      <h5 class="orange">Skriv till oss</h5>
      <h2 class="green">Kom i kontakt med oss</h2>
      <p>Har du frågor om våra program eller tjänster? Vill du veta mer om Islam?
         Använd vårt kontaktformulär så återkopplar vi till dig så snart som möjligt.</p>

      @if(session('ok'))
        <div class="alert alert-success" style="margin:1rem 0">{{ session('ok') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger" style="margin:1rem 0">
          @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
      @endif
    </div>
  </section>

  <section class="section">
    <div class="container contact-box">
      <form class="contact-form" action="{{ route('kontakt.submit') }}" method="post">
        @csrf

        {{-- honeypot --}}
        <input type="text" name="website" tabindex="-1" autocomplete="off"
               style="position:absolute;left:-9999px;opacity:0;height:0;width:0;">

        <div class="form-grid">
          <div class="form-group">
            <label for="namn">Ditt namn *</label>
            <input type="text" id="namn" name="namn" value="{{ old('namn') }}" required>
          </div>
          <div class="form-group">
            <label for="email">Din e-postadress *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
          </div>
          <div class="form-group">
            <label for="telefon">Ditt telefonnummer</label>
            <input type="tel" id="telefon" name="telefon" value="{{ old('telefon') }}">
          </div>
          <div class="form-group">
            <label for="amne">Ämne</label>
            <input type="text" id="amne" name="amne" value="{{ old('amne') }}">
          </div>
        </div>

        <div class="form-group full">
          <label for="meddelande">Ditt meddelande *</label>
          <textarea id="meddelande" name="meddelande" rows="6" required>{{ old('meddelande') }}</textarea>
        </div>

        <div class="form-check">
          <input type="checkbox" id="gdpr" name="gdpr" value="1" {{ old('gdpr') ? 'checked' : '' }} required>
          <label for="gdpr">Jag godkänner att mina personuppgifter behandlas enligt GDPR.</label>
        </div>

        <button type="submit" class="btn-orange">Skicka</button>
      </form>
    </div>
  </section>

  {{-- contact info … --}}
</main>
@endsection

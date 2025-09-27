@extends('layouts.app')

@section('title','Islamisk begravning — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner parallax" data-speed="0.35" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Islamisk begravning</h1>
    <p>Stöd och hjälp när det behövs som mest</p>
  </div>
</section>

<main>
  <!-- Intro -->
  <section class="section intro-grid">
    <figure class="framed">
      <img src="{{ asset('assets/img/services-funeral.jpg') }}" alt="Islamisk begravning">
    </figure>

    <div>
      <h2 class="green">Islamisk begravning</h2>
      <h6 class="orange">STÖD OCH HJÄLP NÄR DET BEHÖVS SOM MEST</h6>
      <p>
        Att förlora en familjemedlem, en släkting eller en nära vän är en stor utmaning.
        Vi på Haninge moskén försöker hjälpa till under dessa svåra tider
        och finnas där som stöd för dem som behöver det.
      </p>
      <p>
        Moskén har ett samarbete med en begravningsbyrå som hjälper med det
        praktiska inför begravningen. Man ber för den döde i moskén och därefter
        åker man till begravningsplatsen.
      </p>
    </div>
  </section>

  <!-- Green band -->
  <section class="banner-img" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
    <div class="overlay"></div>
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

@push('scripts')
<script>
(function(){
  const banners = document.querySelectorAll('.page-banner.parallax');
  if (!banners.length) return;

  const onScroll = () => {
    banners.forEach(b => {
      const rect = b.getBoundingClientRect();
      const speed = parseFloat(b.dataset.speed || 0.35);
      const y = rect.top * speed;
      b.style.backgroundPosition = `center calc(50% + ${y}px)`;
    });
  };

  onScroll();
  window.addEventListener('scroll', onScroll, {passive:true});
  window.addEventListener('resize', onScroll);
})();
</script>
@endpush

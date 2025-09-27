@extends('layouts.app')

@section('title','Nyheter — Haninge Islamiska Forum')

@section('content')

<!-- ===== Banner ===== -->
<section class="page-banner" style="background-image:url('{{ asset('assets/img/om-islam-banner.jpg') }}')">
  <div class="overlay"></div>
  <div class="container banner-inner">
    <h1>Viktig Påminnelse inför Eid-bönen</h1>
  </div>
</section>

<main class="site-main">
  <!-- ===== News list ===== -->
  <section class="section">
    <div class="container">
      <div class="news-grid nyheter-grid">
        <!-- Card 1 -->
        <article class="news-card">
          <h3>Viktig Påminnelse inför Eid-bönen</h3>
          <p class="excerpt">
            Viktig Påminnelse inför Eid-bönen Kära bröder och systrar. Vi ser fram emot att välkomna er till Eid-bönen. 
            För att säkerställa en smidig och respektfull upplevelse …
          </p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-03-28</span>
            <span class="time">18:18:34</span>
          </footer>
        </article>

        <!-- Card 2 -->
        <article class="news-card">
          <h3>Viktig Påminnelse inför Eid-bönen</h3>
          <p class="excerpt">Viktig Påminnelse inför Eid-bönen Kära bröder och systrar. Vi ser fram emot att välkomna er …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-03-24</span>
            <span class="time">13:51:56</span>
          </footer>
        </article>

        <!-- Card 3 -->
        <article class="news-card">
          <h3>Extra årsmöte och fyllnadsval</h3>
          <p class="excerpt">Vi tackar alla våra medlemmar som har närvarat vid extra årsmötet och fyllnadsval …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-23</span>
            <span class="time">21:33:51</span>
          </footer>
        </article>

        <!-- Card 4 -->
        <article class="news-card">
          <h3>Ramadan imsakiy e (Bönetider)</h3>
          <p class="excerpt">Ladda ner bönetider för Ramadan …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-21</span>
            <span class="time">14:51:48</span>
          </footer>
        </article>

        <!-- Card 5 -->
        <article class="news-card">
          <h3>Fyllnadsval Extra Årsmöte 23/02-2025</h3>
          <p class="excerpt">Styrelsen har skickat kallelse via e-post den 2 februari 2025 och den 9 februari 2025 via telefonnummer …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2025-02-09</span>
            <span class="time">15:20:09</span>
          </footer>
        </article>

        <!-- Card 6 -->
        <article class="news-card">
          <h3>Medlems avgift för interna medlemmar</h3>
          <p class="excerpt">Esselamu aleykom Kära bröder och systrar! Som alla känner till så har vi erbjudit alla våra stöd medlemmar till …</p>
          <a href="#" class="readmore">Läs mer »</a>
          <footer class="news-meta">
            <span class="date">2024-10-28</span>
            <span class="time">20:38:21</span>
          </footer>
        </article>
      </div>

      <!-- Pagination -->
      <nav class="pager" aria-label="Sidanavigering">
        <a class="page disabled" href="#" aria-disabled="true">« Föregående</a>
        <a class="page is-active" href="#">1</a>
        <a class="page" href="#">2</a>
        <a class="page" href="#">3</a>
        <a class="page" href="#">Nästa »</a>
      </nav>
    </div>
  </section>
</main>

@endsection

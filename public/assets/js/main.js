// assets/js/main.js
// Mobile menu + submenu
const qs = (s, c=document)=>c.querySelector(s);
const qsa = (s, c=document)=>Array.from(c.querySelectorAll(s));

const yearEl = qs('#year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

const navToggle = qs('.nav-toggle');
const menu = qs('.menu');

if (navToggle && menu){
  navToggle.addEventListener('click', ()=>{
    const open = menu.classList.toggle('open');
    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
}

// Desktop submenu on hover / focus; Mobile on click
qsa('.has-submenu').forEach((li)=>{
  const toggle = qs('.submenu-toggle', li);

  // Desktop hover
  li.addEventListener('mouseenter', ()=>{ if (window.innerWidth>980){ li.classList.add('open'); toggle.setAttribute('aria-expanded','true'); }});
  li.addEventListener('mouseleave', ()=>{ if (window.innerWidth>980){ li.classList.remove('open'); toggle.setAttribute('aria-expanded','false'); }});

  // Mobile click
  toggle.addEventListener('click', (e)=>{
    if (window.innerWidth<=980){
      e.preventDefault();
      const isOpen = li.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
  });
  // ===== HERO VIDEO SLIDER (add to assets/js/main.js) =====
// assets/js/main.js

// ===== Helpers =====
const qs  = (s, c = document) => c.querySelector(s);
const qsa = (s, c = document) => Array.from(c.querySelectorAll(s));

// ===== Footer year =====
const yearEl = qs('#year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

// ===== Mobile menu toggle =====
const navToggle = qs('.nav-toggle');
const menu = qs('.menu');

if (navToggle && menu) {
  navToggle.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
}

// ===== Desktop hover / Mobile click for submenu =====
qsa('.has-submenu').forEach((li) => {
  const toggle = qs('.submenu-toggle', li);
  if (!toggle) return;

  // Desktop hover/focus
  li.addEventListener('mouseenter', () => {
    if (window.innerWidth > 980) {
      li.classList.add('open');
      toggle.setAttribute('aria-expanded', 'true');
    }
  });
  li.addEventListener('mouseleave', () => {
    if (window.innerWidth > 980) {
      li.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Mobile click
  toggle.addEventListener('click', (e) => {
    if (window.innerWidth <= 980) {
      e.preventDefault();
      const isOpen = li.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
  });
}); // ← مهم: نغلق حلقة forEach قبل أي سكربت آخر

// ===== HERO SLIDER (يدعم صور أو فيديو) =====
(function () {
  const slider = qs('.hero-slider');
  if (!slider) return;

  const slides = qsa('.hero-slide', slider);
  if (slides.length === 0) return;

  const dots   = qsa('.hero-controls .hero-dot');
  const btnPP  = qs('.hero-controls .hero-playpause');

  let idx = 0;
  let autoPlay = slides.length > 1;
  const INTERVAL = 6000;
  let timer = null;

  // ترجع عنصر <video> أو <img> داخل السلايد
  const getMedia = (slide) =>
    slide.querySelector('video') || slide.querySelector('img');

  function activate(i) {
    slides.forEach((el, k) => {
      const active = k === i;
      el.classList.toggle('is-active', active);
      el.setAttribute('aria-hidden', active ? 'false' : 'true');

      const v = el.querySelector('video');
      if (v) {
        if (active && autoPlay) {
          const play = () => v.play().catch(() => {});
          if (v.readyState < 2) {
            v.addEventListener('loadeddata', play, { once: true });
            v.load();
          } else {
            play();
          }
        } else {
          v.pause();
          v.currentTime = 0;
        }
      }
    });

    dots.forEach((d, k) => d.classList.toggle('is-active', k === i));
    idx = i;
  }

  function next() {
    activate((idx + 1) % slides.length);
  }

  function start() {
    if (timer) clearInterval(timer);
    if (!autoPlay || slides.length < 2) return;
    timer = setInterval(next, INTERVAL);
    if (btnPP) {
      btnPP.dataset.state = 'playing';
      btnPP.textContent = '❚❚';
      btnPP.setAttribute('aria-label', 'Pausa animationen');
    }
  }

  function stop() {
    if (timer) clearInterval(timer);
    timer = null;
    if (btnPP) {
      btnPP.dataset.state = 'paused';
      btnPP.textContent = '►';
      btnPP.setAttribute('aria-label', 'Spela upp animationen');
    }
  }

  // dots
  dots.forEach((d, k) => {
    d.addEventListener('click', () => {
      stop();
      activate(k);
    });
  });

  // play/pause
  if (btnPP) {
    btnPP.addEventListener('click', () => {
      if (timer) stop(); else { autoPlay = true; start(); }
    });
  }

  // إيقاف التشغيل عند تغيير التبويب
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stop();
    else if (autoPlay) start();
  });

  // مراعاة تقليل الحركة
  const prefersReduced = window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReduced) {
    autoPlay = false;
    stop();
  } else {
    start();
  }

  // فعل أول سلايد
  activate(0);

  // لو أول سلايد فيديو، شغّلو فورًا
  const firstMedia = getMedia(slides[0]);
  if (firstMedia && firstMedia.tagName === 'VIDEO') {
    const v = firstMedia;
    const play = () => v.play().catch(() => {});
    if (v.readyState < 2) {
      v.addEventListener('loadeddata', play, { once: true });
      v.load();
    } else {
      play();
    }
  }
})();


});

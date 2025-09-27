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
(function(){
  const slider = document.querySelector('.hero-slider');
  if(!slider) return;

  const slides = Array.from(slider.querySelectorAll('.hero-slide'));
  const videos = slides.map(s => s.querySelector('video'));
  const dots = Array.from(document.querySelectorAll('.hero-dot'));
  const btnPP = document.querySelector('.hero-playpause');

  let idx = 0;
  let auto = true;
  const DURATION = 6000; // ms
  let timer = null;

  // Helper: activate a slide
  function goTo(i){
    if(i === idx) return;
    const prev = slides[idx];
    const next = slides[i];

    // pause prev video
    const pv = videos[idx];
    if(pv){ pv.pause(); pv.currentTime = 0; }

    // swap classes/ARIA
    prev.classList.remove('is-active'); prev.setAttribute('aria-hidden','true');
    next.classList.add('is-active');    next.setAttribute('aria-hidden','false');

    // update dots
    dots[idx]?.classList.remove('is-active');
    dots[i]?.classList.add('is-active');

    idx = i;

    // play next video (autoplay muted)
    const nv = videos[idx];
    if(nv){
      const play = () => nv.play().catch(()=>{ /* ignore autoplay block */ });
      // ensure load for metadata-only
      if(nv.readyState < 2){ nv.addEventListener('loadeddata', play, {once:true}); nv.load(); }
      else play();
    }
  }

  function next(){ goTo( (idx+1) % slides.length ); }

  function start(){
    if(timer) clearInterval(timer);
    timer = setInterval(next, DURATION);
    auto = true;
    if(btnPP){ btnPP.dataset.state = 'playing'; btnPP.textContent = '❚❚'; btnPP.setAttribute('aria-label','Pausa animationen'); }
  }
  function stop(){
    if(timer) clearInterval(timer);
    timer = null;
    auto = false;
    if(btnPP){ btnPP.dataset.state = 'paused'; btnPP.textContent = '▶'; btnPP.setAttribute('aria-label','Spela upp animationen'); }
  }

  // Init: mark ARIA controls
  slides.forEach((s,i)=>s.id = `hero-slide-${i}`);
  dots.forEach(d=>{
    d.addEventListener('click', ()=>{ stop(); goTo(parseInt(d.dataset.go,10)||0); });
  });
  btnPP?.addEventListener('click', ()=> (auto ? stop() : start()));

  // Pause when not visible (tab hidden) & resume when visible
  document.addEventListener('visibilitychange', ()=>{
    if(document.hidden) stop(); else if(!auto) return; else start();
  });

  // Reduce Motion: stop autoplay
  const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(prefersReduced) stop(); else start();

  // Autoplay first video immediately
  const first = videos[0];
  if(first){
    const playFirst = () => first.play().catch(()=>{});
    if(first.readyState < 2){ first.addEventListener('loadeddata', playFirst, {once:true}); first.load(); }
    else playFirst();
  }
})();

});

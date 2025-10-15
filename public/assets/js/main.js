// assets/js/main.js
// يعتمد على utils.js (يوفر $, $$)

(function () {
  // ===== Footer year =====
  const yearEl = $('#year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // ===== Mobile menu toggle =====
  const navToggle = $('.nav-toggle');
  const menu = $('.menu');
  if (navToggle && menu) {
    navToggle.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // ===== Desktop hover / Mobile click for submenu =====
  $$('.has-submenu').forEach((li) => {
    const toggle = $('.submenu-toggle', li);
    if (!toggle) return;

    // Desktop
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

    // Mobile
    toggle.addEventListener('click', (e) => {
      if (window.innerWidth <= 980) {
        e.preventDefault();
        const isOpen = li.classList.toggle('open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      }
    });
  });

  // ===== (اختياري) شيفرة السلايدر لو تحتاجها لاحقًا... =====
})();

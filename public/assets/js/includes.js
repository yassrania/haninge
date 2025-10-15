

(async function loadPartials(){
  const loadOne = async (el) => {
    const path = el.getAttribute('data-include');
    if(!path) return;
    try{
      const res = await fetch(path, {cache:'no-cache'});
      const html = await res.text();
      el.innerHTML = html;

      // فعّل أي <script> داخل الجزئية
     // داخل loadOne في includes.js — استبدل كتلة تفعيل السكربتات بهذه:
el.querySelectorAll('script').forEach(s => {
  const src = (s.getAttribute('src') || '').toLowerCase();

  // لا تعِد تحميل سكربتات تسبب تضارباً
  const blacklist = ['alpine', 'livewire', 'filament', 'utils.js', 'includes.js', 'main.js'];
  if (src && blacklist.some(k => src.includes(k))) return;

  // امنع السكربتات الخارجية (CDN) من الإعادة
  if (src) {
    try {
      const u = new URL(src, location.href);
      if (u.origin !== location.origin) return;
    } catch (_) { /* ignore */ }
  }

  const ns = document.createElement('script');
  [...s.attributes].forEach(a => ns.setAttribute(a.name, a.value));

  // إن كان type="module" قد يكسر صفحاتك، أزله
  if (ns.type === 'module') ns.removeAttribute('type');

  ns.textContent = s.textContent;
  s.replaceWith(ns);
});


document.addEventListener('DOMContentLoaded', ()=>{
  document.querySelectorAll('.has-submenu > .submenu-toggle').forEach(link=>{
    link.addEventListener('click', e=>{
      // لو كان في شاشة صغيرة (موبايل) → منع الانتقال وفتح القائمة
      if(window.innerWidth < 981){
        e.preventDefault();
        const parent = link.closest('.has-submenu');
        const expanded = link.getAttribute('aria-expanded') === 'true';
        link.setAttribute('aria-expanded', String(!expanded));
        parent.classList.toggle('open', !expanded);
      }
      // في الديسكتوب → يمشي مباشرة للصفحة tjanster.html
    });
  });
});

// إظهار حقل "Övrigt" عند اختيارها
  (function(){
    const otherInput = document.getElementById('langOther');
    const radios = document.querySelectorAll('input[name="lang"]');
    const toggle = () => {
      const val = [...radios].find(r => r.checked)?.value;
      otherInput.style.display = (val === 'Other') ? 'block' : 'none';
      if (val !== 'Other') otherInput.value = '';
    };
    radios.forEach(r => r.addEventListener('change', toggle));
    toggle();

    // فحص سريع عند الإرسال (تقدّر تغيّره إلى معالجة حقيقية لاحقًا)
    document.getElementById('kidsApplication').addEventListener('submit', function(e){
      if(!this.checkValidity()){
        e.preventDefault();
        alert('Kontrollera att alla obligatoriska fält är ifyllda.');
      }
    });
  })();
  
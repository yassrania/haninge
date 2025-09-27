

(async function loadPartials(){
  const loadOne = async (el) => {
    const path = el.getAttribute('data-include');
    if(!path) return;
    try{
      const res = await fetch(path, {cache:'no-cache'});
      const html = await res.text();
      el.innerHTML = html;

      // فعّل أي <script> داخل الجزئية
      el.querySelectorAll('script').forEach(s=>{
        const ns = document.createElement('script');
        [...s.attributes].forEach(a=>ns.setAttribute(a.name,a.value));
        ns.textContent = s.textContent;
        s.replaceWith(ns);
      });
    }catch(e){ console.error('Include failed:', path, e); }
  };

  // حمّل كل العناصر اللي فيها data-include
  const targets = document.querySelectorAll('[data-include]');
  for(const t of targets){ await loadOne(t); }

  // مثال: سنة الفوتر
  const setYear = () => {
    const y = document.getElementById('year');
    if(y) y.textContent = new Date().getFullYear();
  };
  // جرّب تعيينها الآن وبعد إدراج الفوتر
  setYear();
  setTimeout(setYear, 100);
})();

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
  
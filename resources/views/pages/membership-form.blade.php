<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Medlemskap – Ansökan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body { padding: 20px; }
    canvas { border:1px dashed #999; border-radius:6px; }
  </style>
</head>
<body>
  <div class="container py-4">
    
    <h1 class="mb-3">Medlemskap – Ansökan</h1>

    <form method="POST" action="{{ route('membership.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label class="form-label">Fullständigt namn *</label>
        <input type="text" name="full_name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">E-post *</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Telefon</label>
          <input type="text" name="phone" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Adress</label>
          <input type="text" name="address" class="form-control">
        </div>
      </div>

      <div class="mb-3 mt-3">
        <label class="form-label">Anteckningar</label>
        <textarea name="notes" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-2">
        <label class="form-label">Underskrift (bild)</label>
        <input type="file" name="signature" accept="image/*" class="form-control">
        <div class="form-text">أو وقّع أدناه على الكانفاس واضغط "Använd denna signatur".</div>
      </div>

      <input type="hidden" name="signature_base64" id="signature_base64">

      <div class="mb-3">
        <canvas id="sigPad" width="500" height="160"></canvas>
        <div class="mt-2">
          <button type="button" id="sigClear" class="btn btn-sm btn-outline-secondary">Rensa</button>
          <button type="button" id="sigUse" class="btn btn-sm btn-outline-primary">Använd denna signatur</button>
        </div>
      </div>

      <button class="btn btn-primary">Skicka</button>
    </form>
  </div>

  <script>
  (function(){
    const c   = document.getElementById('sigPad');
    const ctx = c.getContext('2d');
    ctx.lineWidth = 2; ctx.lineCap = 'round';
    let drawing=false, last=null;

    function pos(e){
      const r=c.getBoundingClientRect();
      const t=e.touches?.[0] || e;
      return {x: t.clientX - r.left, y: t.clientY - r.top};
    }
    function start(e){ drawing=true; last=pos(e); }
    function move(e){
      if(!drawing) return;
      const p=pos(e);
      ctx.beginPath(); ctx.moveTo(last.x,last.y); ctx.lineTo(p.x,p.y); ctx.stroke();
      last=p;
    }
    function end(){ drawing=false; }

    // mouse
    c.addEventListener('mousedown', start);
    c.addEventListener('mousemove', move);
    c.addEventListener('mouseup', end);
    c.addEventListener('mouseleave', end);

    // touch
    c.addEventListener('touchstart', e=>{e.preventDefault(); start(e);}, {passive:false});
    c.addEventListener('touchmove',  e=>{e.preventDefault(); move(e); }, {passive:false});
    c.addEventListener('touchend',   e=>{e.preventDefault(); end();   }, {passive:false});

    document.getElementById('sigClear').onclick = ()=>{
      ctx.clearRect(0,0,c.width,c.height);
      document.getElementById('signature_base64').value='';
    };
    document.getElementById('sigUse').onclick = ()=>{
      document.getElementById('signature_base64').value = c.toDataURL('image/png');
      alert('تم حفظ التوقيع من الكانفاس. أرسل الفورم الآن.');
    };
  })();
  </script>
</body>
</html>

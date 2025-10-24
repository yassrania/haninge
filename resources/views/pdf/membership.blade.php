<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <title>ANSÖKAN OM MEDLEMSKAP I Haninge Islamiska Forum</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  {{-- ====== Print-safe sizing & base styles ====== --}}
  <style>
  /* Container */
  .page-wrap {
    max-width: 960px;
    margin: 0 auto;
    padding: 16px;
  }

  /* Form grid (mobile-first: 1 column) */
  .form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  /* Make selected rows 2 columns on >= 700px */
  @media (min-width: 700px) {
    .grid-2 {
      grid-template-columns: 1fr 1fr;
    }
  }

  /* Form controls full width */
  .form-control, .input-group, .btn {
    width: 100%;
    box-sizing: border-box;
  }
  .input-group { display: grid; grid-template-columns: 1fr auto; gap: 8px; }

  /* Buttons row: stack on mobile, inline on wide */
  .btn-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: flex-end;
  }
  .btn-row .btn { flex: 1 1 100%; }          /* full width on small */
  @media (min-width: 480px) {
    .btn-row .btn { flex: 0 0 auto; }        /* auto width on larger */
  }

  /* Alerts responsive spacing */
  .alert { padding: 12px 14px; border-radius: 8px; }
  .alert-info { background: #e9f4ff; border: 1px solid #cfe8ff; }
  .alert-success { background: #ecfbf0; border: 1px solid #cbf3d6; }
  .alert-danger  { background: #fdecec; border: 1px solid #f6caca; }

  /* Labels + helpers */
  .form-label { display:block; font-weight: 600; margin-bottom: 6px; }
  .form-text { color:#6c757d; font-size: .9rem; }

  /* Buttons with white text */
  /* Base buttons: normal height */
.btn {
  color:#fff !important;
  border: none;
  border-radius: 8px;
  padding: .475rem .85rem;   /* was 10px 14px */
  line-height: 1.2;          /* tighter line-height */
  font-size: .95rem;         /* slightly smaller text */
}

/* Don't force full width by default */
.btn { width: auto; }

/* In the input-group, keep button compact */
.input-group .btn {
  align-self: start;         /* prevents stretch to full height */
}

/* In the action row: stack on small screens only */
.btn-row .btn { flex: 0 0 auto; }
@media (max-width: 479px) {
  .btn-row .btn { flex: 1 1 100%; }   /* full width only on tiny screens */
}

/* Keep white text on variants */
.btn-primary   { background:#0d6efd; }
.btn-secondary { background:#6c757d; }
.btn-success   { background:#198754; }
.btn-dark      { background:#212529; }
.btn-outline-dark { background:#212529; border:1px solid #212529; }


  /* Signature pad responsive */
  #signature-pad {
    display:block;
    width: 100%;
    height: 180px; /* visual height; canvas pixels handled in JS */
    background:#fff;
    border:1px solid #ced4da;
    border-radius: 8px;
  }
</style>

</head>
<body>

@php
  // Define logo paths ONCE so both branches can use them
  $leftLogo  = asset('images/ikus-left.png');
  $rightLogo = asset('images/ikus-right.png');
@endphp

{{-- ===== Toolbar (screen only) ===== --}}
@if (!($showForm ?? false))
  <div class="no-print print-toolbar">
    <button type="button" class="btn" onclick="window.print()">🖨️ Skriv ut</button>
  </div>
@endif

@if (!empty($showForm))
  {{-- ==================== FORM (GET) ==================== --}}
  <div class="container">
    
    <div class="paper">
     <center> <h1  style="color: #5C5797;">ANSÖKAN OM MEDLEMSKAP<br>
       I Haninge Islamiska Forum</h1></center>
<br><br><br>
{{-- Info box at top of the form --}}
<div class="alert alert-info" role="alert">
  <h5 class="mb-2">Så här fyller du i formuläret</h5>
  <ol class="mb-2">
    <li>Fyll i alla fält markerade med <strong>*</strong>.</li>
    <li>Ange korrekt <strong>e-post</strong> och <strong>telefonnummer</strong>.</li>
    <li>Klicka på <em>”Få kod”</em> för att få en verifieringskod till din e-post.</li>
    <li><strong>Öppna din inkorg och skriv sedan in koden i fältet ”Verifieringskod”.</strong></li>
    <li>Koden är giltig i 10 minuter.</li>

    <li>Klicka på <em>”Skicka in”</em> för att skicka in ansökan.</li>
  </ol>
</div>

      <form method="POST" action="{{ route('membership.store') }}" enctype="multipart/form-data" class="mb-4">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Fullständigt namn *</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">E-post *</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label mt-3">Telefon *</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label mt-3">Adress *</label>
            <input type="text" name="address" class="form-control">
          </div>
        </div>
{{-- 

      <div class="mt-3">
          <label class="form-label">Anteckningar</label>
          <textarea name="notes" rows="3" class="form-control"></textarea>
        </div>

        <hr class="my-4">
 --}}
        <div class="mb-2">
         <br><br>
          <label class="form-label"> Underskrift *</label>

        
      
<input type="hidden" name="signature_base64" id="signature_base64">
  </div>
        <div class="mb-3">
          <canvas id="sigPad" width="520" height="170" style="border:1px dashed #999; border-radius:6px;"></canvas>
          <div class="mt-2">
            <button type="button" id="sigClear" class="btn btn-sm btn-secondary">Rensa</button>
          </div>
        </div>
{{-- زر إرسال رمز التحقق --}}
<div class="mt-2">
   <label class="form-label"> Klicka på knappen nedan för att få koden:</label>
<div class="mt-3 d-flex gap-2">
   
    <button type="button" id="sendOtpBtn" class="btn btn-secondary">Få verifieringskod </button>
    <span id="otpStatus" class="text-muted small"></span>
</div>

{{-- خانة إدخال الرمز --}}
<div class="mt-3 col-md-4">
    <label class="form-label">Verifieringskod (OTP)</label>
    <input type="text" name="otp_code" class="form-control" inputmode="numeric" pattern="\d{6}" placeholder="******">
    @error('otp_code') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
<br>
        <button class="btn btn-primary">Skicka in</button>
      </form>
    </div>
  </div>
 </div>
  <script>
  (function(){
    const c   = document.getElementById('sigPad');
    const ctx = c?.getContext && c.getContext('2d');
    if (!ctx) return;

    ctx.lineWidth = 2; ctx.lineCap = 'round';
    let drawing=false, last=null;

    const pos = (e) => {
      const r = c.getBoundingClientRect();
      const t = e.touches?.[0] || e;
      return { x: t.clientX - r.left, y: t.clientY - r.top };
    };
    const start = (e) => { drawing = true; last = pos(e); };
    const move  = (e) => { if(!drawing) return; const p = pos(e);
      ctx.beginPath(); ctx.moveTo(last.x,last.y); ctx.lineTo(p.x,p.y); ctx.stroke(); last = p; };
    const end = () => { drawing = false; };

    c.addEventListener('mousedown', start);
    c.addEventListener('mousemove', move);
    c.addEventListener('mouseup', end);
    c.addEventListener('mouseleave', end);

    c.addEventListener('touchstart', (e)=>{ e.preventDefault(); start(e); }, {passive:false});
    c.addEventListener('touchmove',  (e)=>{ e.preventDefault(); move(e);  }, {passive:false});
    c.addEventListener('touchend',   (e)=>{ e.preventDefault(); end();    }, {passive:false});

    document.getElementById('sigClear')?.addEventListener('click', () => {
      ctx.clearRect(0,0,c.width,c.height);
      document.getElementById('signature_base64').value = '';
    });
    document.getElementById('sigUse')?.addEventListener('click', () => {
      document.getElementById('signature_base64').value = c.toDataURL('image/png');
      alert('تم حفظ التوقيع من الكانفاس. أرسل الفورم الآن.');
    });

    function isCanvasBlank(canvas){
      const data = canvas.getContext('2d').getImageData(0,0,canvas.width,canvas.height).data;
      for(let i=3;i<data.length;i+=4){ if(data[i] !== 0) return false; }
      return true;
    }

    const form = document.querySelector('form');
    form.addEventListener('submit', () => {
      const input = document.getElementById('signature_base64');
      if (input.value === '' && !isCanvasBlank(c)) {
        input.value = c.toDataURL('image/png');
      }
    });
  })();
  </script>

@else
  {{-- ==================== PRINT / VIEW (POST) ==================== --}}
  <div class="containerp">
    <div class="paper">

      {{-- Top information block in two fixed columns --}}
      <div class="intro-2col">
        <div>
          <p style="color:#F1B300;" ><b>KORT INFORMATION OM SKRIFTLIGT MEDGIVANDE</b></p>
          <p>
            Om du vill stödja din lokala moské och riksförbundet Islamiska
            Kulturcenterunionen i Sverige (IKUS) med en moskéavgift genom
            Skatteverket behöver du skicka in ett skriftligt medgivande
            (se blanketten nedan).
          </p>
        </div>
        <div>
          <p>
            Medgivandet gäller för hela kalenderåret och behöver inte förnyas.
            Vill du ändra vilken lokal moské som din avgift går till kan du göra
            det när som helst. När vi har tagit emot ditt medgivande med posten
            får du en skriftlig bekräftelse. Detsamma gäller vid alla förändringar
            som du vill göra i medgivandet med posten.
          </p>
        </div>
      </div>

      {{-- Logos + centered title --}}
      <div class="brandband">
        <img class="brand" src="{{ $leftLogo }}"  alt="IKUS vänster">
        <div class="brandband__title">
          ANSÖKAN OM MEDLEMSKAP I Haninge Islamiska Forum
          <small>MEDGIVANDE FÖR MOSKÉAVGIFT TILL IKUS</small>
        </div>
        <img class="brand" src="{{ $rightLogo }}" alt="IKUS höger">
      </div>

      <div style="height:6mm"></div>

      <p style="margin:0 0 4mm;">
        Härmed ansöker jag om medlemskap i Haninge Islamiska Forum
        <b>(Orgnr: 802496-2048).</b>
      </p>
      <p style="margin:0 0 8mm;">
        Härmed ger jag mitt medgivande till att Skatteverket fr.o.m. nästa
        kalenderår och tills vidare uttar 1 procent (1 %) av min kommunalt
        beskattningsbara förvärvsinkomst som moskéavgift till
        <strong>IKUS (orgnr: 252002-8750)</strong>.
      </p>

      <div style="margin-bottom:8mm;">
        <div class="kv"><div class="k"><b>Namn/Efternamn:</b></div><div class="v">{{ $full_name ?? '' }}</div></div><br>
        <div class="kv"><div class="k"><b>Adress:</b></div><div class="v">{{ $address ?? '' }}</div></div><br>
        <div class="kv"><div class="k"><b>Telefon:</b></div><div class="v">{{ $phone ?? '' }}</div></div><br>
        <div class="kv"><div class="k"><b>E-post:</b></div><div class="v">{{ $email ?? '' }}</div></div><br>
        <div class="kv"><div class="k"><b>Datum:</b></div><div class="v">{{ $submitted_at ?? now()->format('Y-m-d H:i') }}</div></div>
      </div>

      @if(!empty($notes))
        <h5>Anteckningar</h5>
        <div style="margin-bottom:8mm;">{!! nl2br(e($notes)) !!}</div>
      @endif

      <h3 class="signature-title">Underskrift</h3>
      <div class="signature-box">
        @if ($signature_base64)
          <img src="{{ $signature_base64 }}" alt="Signatur">
        @elseif (!empty($signature_text))
          <div style="font-size:22px; font-style:italic; padding:6px 0;">
            {{ $signature_text }}
          </div>
        @else
          <div style="opacity:.7;">Ingen signatur angavs</div>
        @endif
      </div>

      <div style="height:10mm"></div>

      <section class="foot-notes">
        <p style="color:red;"><strong>* Obligatoriska uppgifter</strong></p>
        <ol style="padding-left: 18px; margin:0;">
          <li>Skicka in senast 31 oktober till Bergsbo v 15, 191 35 Sollentuna, för att hinna ge moskéavgift för följande kalenderår.</li>
          <li>Varje person bör fylla i en separat blankett.</li>
          <li>De uppgifter du angett kommer att behandlas elektroniskt för internt bruk på IKUS.</li>
          <li>Du behöver inte själv kontakta Skatteverket. Det sker via IKUS när du sänt in detta medgivande.</li>
          <li>Medgivandet kan inte skickas som e-post eller faxas. Det måste undertecknas och skickas med post eller lämnas in personligen.</li>
        </ol>
      </section>

      <div style="height:6mm"></div>

      <div class="text-center" style="font-size:12px; color:#666;">
        © {{ date('Y') }} Haninge Islamiska Forum — Denna sida kan skrivas ut eller sparas som PDF.
      </div>

    </div>
  </div>
@endif


<script>
document.getElementById('sendOtpBtn')?.addEventListener('click', async () => {
  const email = document.querySelector('input[name="email"]')?.value?.trim();
  const name  = document.querySelector('input[name="full_name"]')?.value?.trim();
  const status= document.getElementById('otpStatus');

  if (!email) { alert('Skriv e-post först'); return; }

  try {
    status.textContent = 'Det skikas...';
    const res = await fetch('{{ route("membership.send-otp") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ email, full_name: name })
    });
    const data = await res.json();
    status.textContent = data.message || 'Kod skickad (om någon).';
  } catch (e) {
    status.textContent = 'Kunde inte skicka, försök igen senare.';
  }
});
</script>
<script>
  // ----- OTP send -----
  const sendBtn = document.getElementById('sendOtpBtn');
  const emailInput = document.getElementById('email');
  const otpSent = document.getElementById('otpSentMsg');
  const otpErr  = document.getElementById('otpErrorMsg');

  sendBtn?.addEventListener('click', async () => {
    if (otpSent) otpSent.style.display = 'none';
    if (otpErr)  otpErr.style.display  = 'none';

    const email = (emailInput?.value || '').trim();
    if (!email) {
      if (otpErr) { otpErr.textContent = 'Ange en giltig e-postadress först.'; otpErr.style.display = 'block'; }
      return;
    }

    sendBtn.disabled = true;
    const oldText = sendBtn.textContent;
    sendBtn.textContent = 'Skickar...';

    try {
      const res = await fetch("{{ route('membership.send-otp') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email })
      });

      if (!res.ok) throw new Error('Bad response');
      if (otpSent) otpSent.style.display = 'block';
    } catch (e) {
      if (otpErr) otpErr.style.display = 'block';
    } finally {
      sendBtn.disabled = false;
      sendBtn.textContent = oldText;
    }
  });

  // ----- Signature pad (vanilla) -----
  const canvas = document.getElementById('signature-pad');
  const sigInput = document.getElementById('signatureData');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let strokes = [], current = [], drawing = false;

    function deviceRatio(){ return Math.max(window.devicePixelRatio || 1, 1); }
    function resizeCanvas(){
      const ratio = deviceRatio();
      const cssW = canvas.clientWidth;
      const cssH = canvas.clientHeight;
      canvas.width  = Math.floor(cssW * ratio);
      canvas.height = Math.floor(cssH * ratio);
      ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
      redraw();
    }
    function redraw(){
      ctx.clearRect(0,0,canvas.clientWidth,canvas.clientHeight);
      ctx.lineWidth = 2;
      ctx.lineCap = 'round';
      ctx.strokeStyle = '#000';
      for (const s of strokes) {
        ctx.beginPath();
        s.forEach((p,i)=> i? ctx.lineTo(p.x,p.y) : ctx.moveTo(p.x,p.y));
        ctx.stroke();
      }
    }
    function pos(e){
      const r = canvas.getBoundingClientRect();
      const t = e.touches ? e.touches[0] : e;
      return { x: t.clientX - r.left, y: t.clientY - r.top };
    }
    function start(e){ drawing = true; current = [pos(e)]; strokes.push(current); }
    function move(e){
      if (!drawing) return;
      current.push(pos(e));
      redraw();
      const L = current.length;
      if (L > 1) {
        ctx.beginPath();
        ctx.moveTo(current[L-2].x, current[L-2].y);
        ctx.lineTo(current[L-1].x, current[L-1].y);
        ctx.stroke();
      }
    }
    function end(){
      drawing = false;
      if (sigInput) sigInput.value = canvas.toDataURL('image/png');
    }

    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', end);
    canvas.addEventListener('touchstart', (e)=>{ e.preventDefault(); start(e); }, {passive:false});
    canvas.addEventListener('touchmove',  (e)=>{ e.preventDefault(); move(e);  }, {passive:false});
    canvas.addEventListener('touchend',   (e)=>{ e.preventDefault(); end();    }, {passive:false});

    document.getElementById('clearSignature')?.addEventListener('click', ()=>{
      strokes = []; redraw(); if (sigInput) sigInput.value = '';
    });
    document.getElementById('undoSignature')?.addEventListener('click', ()=>{
      strokes.pop(); redraw(); if (sigInput) sigInput.value = strokes.length ? canvas.toDataURL('image/png') : '';
    });

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
  }
</script>

</body>
</html>

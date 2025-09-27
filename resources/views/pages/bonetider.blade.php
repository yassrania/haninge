@extends('layouts.app')

@section('title','Bönetider — Haninge Islamiska Forum')

@section('content')

<!-- ===== Bönetider Arch ===== -->
<section class="bonetider">
  <div class="arch-wrap container">
    <div class="arch-card">
      <div class="arch-head">
        <div class="brand">
          <img src="{{ asset('assets/img/logo-mark-gold.svg') }}" alt="Haninge Islamiska Forum" style="width:54px">
        </div>
        <div class="title">
          <h2>Bönetider</h2>
          <h1 id="monthTitle">—</h1>
        </div>
        <div style="width:54px"></div>
      </div>

      <!-- Kontroller -->
      <div class="controls" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin:8px 0 6px">
        <label>Stad/Plats:
          <input id="place" type="text" placeholder="Botkyrka" style="padding:8px;border:1px solid #ccc;border-radius:8px">
        </label>
        <label>Lat:
          <input id="lat" type="number" step="0.000001" style="width:120px;padding:8px;border:1px solid #ccc;border-radius:8px">
        </label>
        <label>Lng:
          <input id="lng" type="number" step="0.000001" style="width:120px;padding:8px;border:1px solid #ccc;border-radius:8px">
        </label>
        <label>Månad:
          <select id="month" style="padding:8px;border-radius:8px">
            <option value="1">januari</option><option value="2">februari</option><option value="3">mars</option>
            <option value="4">april</option><option value="5">maj</option><option value="6">juni</option>
            <option value="7">juli</option><option value="8">augusti</option><option value="9">september</option>
            <option value="10">oktober</option><option value="11">november</option><option value="12">december</option>
          </select>
        </label>
        <label>År:
          <input id="year" type="number" min="2000" max="2100" style="width:92px;padding:8px;border:1px solid #ccc;border-radius:8px">
        </label>
        <label>Metod:
          <select id="method" title="Beräkningsmetod" style="padding:8px;border-radius:8px">
            <option value="3">Muslim World League</option>
            <option value="2">ISNA</option>
            <option value="5">Egyptian General Authority</option>
            <option value="12">Umm Al-Qura</option>
            <option value="13">Gulf (Dubai)</option>
            <option value="14">Qatar</option>
            <option value="1">University of Islamic Sciences, Karachi</option>
            <option value="99">Custom (API default)</option>
          </select>
        </label>
        <button id="useGeo" type="button" style="padding:10px 12px;border:0;border-radius:8px;background:#15803d;color:#fff;font-weight:700;cursor:pointer">Använd min plats</button>
        <button id="load" type="button" style="padding:10px 12px;border:0;border-radius:8px;background:#ea7e40;color:#fff;font-weight:800;cursor:pointer">Ladda tider</button>
      </div>

      <!-- Tabell -->
      <div style="overflow:auto; max-height:65vh">
        <table class="times" id="timesTable" style="width:100%;border-collapse:collapse;color:#f8fafc">
          <thead>
            <tr>
              <th>Datum</th>
              <th class="c">Dag</th>
              <th class="r">Fajr</th>
              <th class="r">Shuruk</th>
              <th class="r">Dhuhr</th>
              <th class="r">Asr</th>
              <th class="r">Maghrib</th>
              <th class="r">Isha</th>
            </tr>
          </thead>
          <tbody id="timesBody">
            <tr><td colspan="8" style="padding:12px">Laddar…</td></tr>
          </tbody>
        </table>
      </div>

      <div class="print-bar" style="display:flex;justify-content:flex-end;margin-top:10px">
        <button class="btn-print" onclick="window.print()" style="background:#ea7e40;color:#fff;padding:10px 14px;border-radius:10px;border:0;font-weight:800;cursor:pointer">Skriv ut</button>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
/* ===== Hämta bönetider via AlAdhan API ===== */
(function(){
  const body = document.getElementById('timesBody');
  const titleEl = document.getElementById('monthTitle');
  const place = document.getElementById('place');
  const lat = document.getElementById('lat');
  const lng = document.getElementById('lng');
  const month = document.getElementById('month');
  const year = document.getElementById('year');
  const method = document.getElementById('method');
  const btnGeo = document.getElementById('useGeo');
  const btnLoad = document.getElementById('load');

  const today = new Date();
  place.value = 'Botkyrka';
  lat.value = 59.239;
  lng.value = 17.825;
  month.value = (today.getMonth()+1);
  year.value = today.getFullYear();

  const WEEK = ['sön','mån','tis','ons','tor','fre','lör'];
  const MONTHS_SV = ['januari','februari','mars','april','maj','juni','juli','augusti','september','oktober','november','december'];

  function fmt(t){
    if(!t) return '—';
    const m = t.match(/^(\d{1,2}):(\d{2})/);
    return m ? (m[1].padStart(2,'0')+':'+m[2]) : t;
  }

  async function loadTimes(){
    const m = parseInt(month.value,10);
    const y = parseInt(year.value,10);
    const la = parseFloat(lat.value);
    const lo = parseFloat(lng.value);
    const meth = parseInt(method.value,10);

    titleEl.textContent = `${MONTHS_SV[m-1]} ${y}`;
    body.innerHTML = `<tr><td colspan="8" style="padding:12px">Laddar…</td></tr>`;

    try{
      const url = `https://api.aladhan.com/v1/calendar?latitude=${la}&longitude=${lo}&method=${meth}&month=${m}&year=${y}&school=0`;
      const res = await fetch(url);
      const json = await res.json();
      const data = json.data || [];

      if(!data.length){
        body.innerHTML = `<tr><td colspan="8" style="padding:12px">Inga tider hittades.</td></tr>`;
        return;
      }

      const rows = data.map(d=>{
        const greg = d.date.gregorian;
        const wd = new Date(greg.date.split('-').reverse().join('-')).getDay();
        const t = d.timings;
        return `<tr>
          <th>${parseInt(greg.day,10)} ${MONTHS_SV[m-1].slice(0,3)}</th>
          <td class="c">${WEEK[wd]}</td>
          <td class="r">${fmt(t.Fajr)}</td>
          <td class="r">${fmt(t.Sunrise)}</td>
          <td class="r">${fmt(t.Dhuhr)}</td>
          <td class="r">${fmt(t.Asr)}</td>
          <td class="r">${fmt(t.Maghrib)}</td>
          <td class="r">${fmt(t.Isha)}</td>
        </tr>`;
      }).join('');
      body.innerHTML = rows;
    }catch(e){
      console.error(e);
      body.innerHTML = `<tr><td colspan="8" style="padding:12px;color:#fca5a5">Fel vid hämtning av tider.</td></tr>`;
    }
  }

  btnGeo.addEventListener('click', ()=>{
    if(!navigator.geolocation){
      alert('Geolocation stöds inte i den här webbläsaren.');
      return;
    }
    navigator.geolocation.getCurrentPosition(
      pos => { lat.value = pos.coords.latitude.toFixed(6); lng.value = pos.coords.longitude.toFixed(6); place.value='Min plats'; loadTimes(); },
      err => { alert('Kunde inte hämta plats. Tillåt platsåtkomst eller skriv lat/lng manuellt.'); }
    );
  });

  btnLoad.addEventListener('click', loadTimes);
  loadTimes();
})();
</script>
@endpush

{{-- resources/views/admin/parts/topbar-menu.blade.php --}}
<div class="hidden md:flex items-center gap-4">
  <a href="{{ route('home') }}" target="_blank" class="text-sm hover:underline">Startsida</a>
  <a href="{{ route('tjanster') }}" target="_blank" class="text-sm hover:underline">Tjänster</a>
  <a href="{{ route('nyheter') }}" target="_blank" class="text-sm hover:underline">Nyheter</a>
  <a href="{{ route('kontakt') }}" target="_blank" class="text-sm hover:underline">Kontakt</a>
  <a href="{{ route('stod-mosken') }}" target="_blank" class="text-sm font-semibold px-3 py-1 rounded bg-emerald-600 text-white">Stöd moskén</a>
</div>

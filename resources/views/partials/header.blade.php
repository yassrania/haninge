{{-- HIF header v3 — uses Menus from DB, no "Alla tjänster" hardcoded --}}
@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route as RouteFacade;

    // Build the tree directly here to avoid any composer mismatch
    $orderCol = \Illuminate\Support\Facades\Schema::hasColumn('menus', 'order') ? 'order' : 'id';

    $menuTree = Menu::query()
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->with(['children' => function ($q) use ($orderCol) {
            $q->where('is_active', true)->orderBy($orderCol);
        }])
        ->orderBy($orderCol)
        ->get();

    $menuHref = function ($item) {
        if (!empty($item->route_name) && RouteFacade::has($item->route_name)) {
            return route($item->route_name);
        }
        return $item->url ?: '#';
    };

    $isActive = function ($href) {
        try {
            $path = parse_url($href, PHP_URL_PATH) ?: '/';
            return request()->is(ltrim($path, '/').'*');
        } catch (\Throwable $e) {
            return false;
        }
    };
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="line-height:1.2;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 py-2" href="{{ route('home') }}">
      <span class="fw-semibold">{{ config('app.name', 'Haninge Islamiska Forum') }}</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
      aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto align-items-lg-center">

        @foreach($menuTree as $item)
          @php
            $href = $menuHref($item);
            $active = $isActive($href);
            $hasChildren = $item->children && $item->children->count();
          @endphp

          @if($hasChildren)
            <li class="nav-item dropdown" id="menu-item-{{ $item->id }}">
              <a class="nav-link dropdown-toggle py-2 {{ $active ? 'active' : '' }}"
                 href="{{ $href }}"
                 id="dropdown-{{ $item->id }}"
                 role="button"
                 data-bs-toggle="dropdown"
                 aria-expanded="false"
                 @if(!empty($item->new_tab)) target="_blank" rel="noopener" @endif>
                {{ $item->label }}
              </a>

              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-{{ $item->id }}">
                @foreach($item->children as $child)
                  @php $childHref = $menuHref($child); @endphp
                  <li>
                    <a class="dropdown-item {{ $isActive($childHref) ? 'active' : '' }}"
                       href="{{ $childHref }}"
                       @if(!empty($child->new_tab)) target="_blank" rel="noopener" @endif>
                      {{ $child->label }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link py-2 {{ $active ? 'active' : '' }}"
                 href="{{ $href }}"
                 @if(!empty($item->new_tab)) target="_blank" rel="noopener" @endif>
                {{ $item->label }}
              </a>
            </li>
          @endif
        @endforeach

      </ul>
    </div>
  </div>
</nav>

<style>
  .navbar .nav-link { padding-top:.5rem; padding-bottom:.5rem; }   /* normal height */
  .navbar .dropdown-item { padding-top:.45rem; padding-bottom:.45rem; }
  @media (min-width: 992px) { .navbar .dropdown-menu { margin-top: .4rem; } }
</style>

<script>
(function ensureBootstrapBundle(){
  if (!(window.bootstrap && window.bootstrap.Dropdown)) {
    var s = document.createElement('script');
    s.src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js";
    s.defer = true;
    document.head.appendChild(s);
  }
})();
document.addEventListener('DOMContentLoaded', function () {
  const lg = window.matchMedia('(min-width: 992px)');
  document.querySelectorAll('.nav-item.dropdown').forEach(function (item) {
    const toggle = item.querySelector('.dropdown-toggle');
    const menu = item.querySelector('.dropdown-menu');
    if (!toggle || !menu) return;
    let enterT, leaveT;
    function show(){ item.classList.add('show'); menu.classList.add('show'); toggle.setAttribute('aria-expanded','true'); }
    function hide(){ item.classList.remove('show'); menu.classList.remove('show'); toggle.setAttribute('aria-expanded','false'); }
    if (lg.matches) {
      item.addEventListener('mouseenter', ()=>{ clearTimeout(leaveT); enterT=setTimeout(show,60); });
      item.addEventListener('mouseleave', ()=>{ clearTimeout(enterT); leaveT=setTimeout(hide,120); });
      toggle.addEventListener('click', e=>{ if (lg.matches) e.preventDefault(); });
    }
    lg.addEventListener('change', ()=>{ hide(); });
  });
});
</script>

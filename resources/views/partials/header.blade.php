{{-- resources/views/partials/header.blade.php --}}
@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route;

    // عناصر المستوى الأول + الأولاد
    $tops = Menu::whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('order')
        ->with(['children' => fn($q) => $q->where('is_active', true)->orderBy('order')])
        ->get();

    // دالة ترجّع الرابط الصحيح (route إذا كاين وإلا url)
    $urlFor = function ($item) {
        if ($item->route && Route::has($item->route)) {
            return route($item->route);
        }
        return $item->url ?: 'javascript:void(0)';
    };

    // active helper
    $isActive = function ($item) {
        return $item->route && Route::has($item->route) && request()->routeIs($item->route);
    };
@endphp

<header class="site-header">
  <div class="container header-inner">
    <a class="logo" href="{{ route('home') }}">
      <img src="{{ asset('assets/img/logo.svg') }}" alt="Haninge Islamiska Forum" />
    </a>

    <nav class="nav" aria-label="Huvudnavigation">
      <button class="nav-toggle" aria-controls="site-menu" aria-expanded="false">
        <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        <span class="sr-only">Meny</span>
      </button>

      <ul id="site-menu" class="menu">
        @foreach ($tops as $item)
          @if($item->children->count())
            <li class="has-submenu {{ $item->children->contains(fn($c) => $isActive($c)) ? 'open' : '' }}">
              <a href="{{ $urlFor($item) }}"
                 class="submenu-toggle"
                 aria-haspopup="true"
                 aria-expanded="{{ $item->children->contains(fn($c) => $isActive($c)) ? 'true' : 'false' }}">
                {{ $item->label }}
              </a>

              <ul class="submenu" aria-label="Undermeny — {{ $item->label }}">
                @foreach ($item->children as $child)
                  <li>
                    <a href="{{ $urlFor($child) }}"
                       @if($child->new_tab) target="_blank" rel="noopener" @endif
                       class="{{ $child->type === 'cta' ? 'btn btn-small btn-orange' : '' }} {{ $isActive($child) ? 'is-active' : '' }}">
                      {{ $child->label }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li>
              <a href="{{ $urlFor($item) }}"
                 @if($item->new_tab) target="_blank" rel="noopener" @endif
                 class="{{ $item->type === 'cta' ? 'btn btn-small btn-orange' : '' }} {{ $isActive($item) ? 'is-active' : '' }}">
                {{ $item->label }}
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    </nav>
  </div>

  {{-- نفس سكريبت التحكم القديم --}}
  <script>
    (function(){
      const qs=(s,c=document)=>c.querySelector(s);
      const qsa=(s,c=document)=>Array.from(c.querySelectorAll(s));
      const navToggle = qs('.nav-toggle');
      const menu = qs('#site-menu');

      if(navToggle && menu){
        navToggle.addEventListener('click', ()=>{
          const open = menu.classList.toggle('open');
          navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
      }
      qsa('.has-submenu').forEach(li=>{
        const toggle = qs('.submenu-toggle', li);
        li.addEventListener('mouseenter', ()=>{ if (innerWidth>980){ li.classList.add('open'); toggle?.setAttribute('aria-expanded','true'); }});
        li.addEventListener('mouseleave', ()=>{ if (innerWidth>980){ li.classList.remove('open'); toggle?.setAttribute('aria-expanded','false'); }});
        toggle && toggle.addEventListener('click', (e)=>{
          if(innerWidth<=980){ e.preventDefault(); const isOpen = li.classList.toggle('open'); toggle.setAttribute('aria-expanded', isOpen?'true':'false'); }
        });
      });
    })();
  </script>
</header>

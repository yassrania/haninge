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

<header class="site-header border-bottom">
  <div class="container py-2">
    <div class="row align-items-center g-3 flex-nowrap flex-md-wrap">

      {{-- Logo (يسار على الديسكتوب – أعلى في الموبايل) --}}
      <div class="col-auto order-1 order-md-1">
        <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
          @if($site?->logo)
            <img src="{{ Storage::url($site->logo) }}"
                 alt="{{ $site->site_name ?? 'Logo' }}"
                 class="site-logo">
          @else
            <span class="fw-bold fs-4 text-dark">{{ $site->site_name ?? 'Haninge Islamiska Forum' }}</span>
          @endif
        </a>
      </div>

      {{-- Contact (وسط على الديسكتوب – تحت اللوجو في الموبايل) --}}
      <div class="col order-3 order-md-2">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-md-center gap-3 contact-wrap">

          @if($site?->phone)
            <a class="d-inline-flex align-items-center text-decoration-none text-dark"
               href="tel:{{ preg_replace('/\s+/', '', $site->phone) }}">
              <i class="fa fa-phone me-2"></i>
              <span class="small fw-semibold">{{ $site->phone }}</span>
            </a>
          @endif

          @if($site?->email)
            <a class="d-inline-flex align-items-center text-decoration-none text-dark"
               href="mailto:{{ $site->email }}">
              <i class="fa fa-envelope me-2"></i>
              <span class="small fw-semibold">{{ $site->email }}</span>
            </a>
          @endif

        </div>
      </div>

      {{-- Social (يمين على الديسكتوب – أسفل في الموبايل) --}}
      <div class="col-auto order-2 order-md-3 ms-auto">
        @if(is_array($site?->social))
          <div class="d-flex align-items-center gap-3">
            @foreach($site->social as $network => $url)
              @if(!empty($url))
                <a href="{{ $url }}" target="_blank" rel="noopener"
                   class="text-dark social-link" title="{{ ucfirst($network) }}">
                  <i class="fab fa-{{ strtolower($network) }}"></i>
                </a>
              @endif
            @endforeach
          </div>
        @endif
      </div>

    </div>
  </div>
</header>

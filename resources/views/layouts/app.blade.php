<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Haninge Islamiska Forum')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- CSS العام -->
  <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  @stack('styles')
  @stack('head')
</head>
<body>
  @include('partials.header')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  <!-- تمهيد CSRF للأجاكس إن احتجته -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (tokenMeta && window.axios) {
        const token = tokenMeta.getAttribute('content');
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      }
    });
  </script>

  <!-- Alpine للواجهة العامة فقط (نسخة واحدة) -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @stack('scripts')

  <!-- سكربتاتك -->
  <script defer src="/assets/js/utils.js"></script>
  <script defer src="/assets/js/includes.js"></script>
  <script defer src="/assets/js/main.js"></script>
</body>
</html>

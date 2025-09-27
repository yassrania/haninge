<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Haninge Islamiska Forum')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Livewire (اختياري للفرونت) --}}
  @livewireStyles

  {{-- ملفات CSS العامة --}}
  <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

  {{-- مساحة لإضافة ستايلات خاصة بكل صفحة --}}
  @stack('styles')
  @stack('head')
</head>
<body>
  @include('partials.header')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  {{-- سكريبتات عامة (مع defer باش يتحملو بعد الـ DOM) --}}
  <script src="{{ asset('assets/js/utils.js') }}" defer></script>
  <script src="{{ asset('assets/js/includes.js') }}" defer></script>
  <script src="{{ asset('assets/js/main.js') }}" defer></script>

  {{-- تمرير التوكن لطلبات JS (axios/fetch) --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (tokenMeta) {
        const token = tokenMeta.getAttribute('content');
        window.csrfToken = token;
        if (window.axios) {
          window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }
      }
    });
  </script>

  {{-- Livewire (اختياري) --}}
  @livewireScripts

  {{-- مساحة لإضافة سكريبتات خاصة بكل صفحة --}}
  @stack('scripts')
</body>
</html>

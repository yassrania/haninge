<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
  // نخلي Livewire/axios يلقط التوكن إن احتاج
  (function () {
    var m = document.querySelector('meta[name="csrf-token"]');
    if (!m) return;
    window.csrfToken = m.getAttribute('content');
    if (window.axios) {
      axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrfToken;
    }
  })();
</script>

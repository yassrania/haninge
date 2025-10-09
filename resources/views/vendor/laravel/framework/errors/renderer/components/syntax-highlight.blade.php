@props(['code' => '', 'language' => null])

{{-- تعطيل التلوين مؤقتا لأن phiki بيكسر صفحة الأخطاء عندك --}}
<pre class='overflow-auto rounded-md bg-gray-900 text-gray-100 p-4 text-sm'>
{{ is_string() ?  : print_r(, true) }}
</pre>

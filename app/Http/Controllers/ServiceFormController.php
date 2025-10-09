<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceFormController extends Controller
{
    public function submit(Request $request, Service $service)
    {
        // خذ كل شيء ما عدا التوكن
        $payload = $request->except(['_token']);

        // حدّد الموديل حسب هدف الصندوق
        $target = $service->inbox_target; // مثال: 'vigsel_inquiry'
        $map = [
            'vigsel_inquiry' => \App\Models\Inbox\VigselInquiry::class,
            // زِد أهداف أخرى هنا لو عندك
        ];
        $modelClass = $map[$target] ?? \App\Models\Inbox\VigselInquiry::class;

        // استخرج الاسم والإيميل والهاتف بدون افتراض أسماء ثابتة:
        $first = $this->first($request, [
            'name_first','first_name','fornamn','fname','given_name','groom_first_name','bride_first_name','brud_for_namn'
        ]);
        $last = $this->first($request, [
            'name_last','last_name','efternamn','lname','family_name','groom_last_name','bride_last_name','brud_efter_namn'
        ]);
        $fullName = trim(($first ?? '') . ' ' . ($last ?? ''));
        if (!$fullName) {
            // إن لم نجد First/Last، جرّب حقول عامة
            $fullName = $this->first($request, ['name','full_name','namn','fullname']);
        }

        $email = $this->first($request, [
            'email','epost','e-post','epostadress','email_address','mail'
        ]);

        $phone = $this->first($request, [
            'phone','tel','telefon','telefonnummer','mobile','mobil'
        ]);

        // خزّن سجل واحد شامل
        $modelClass::create([
            'service_id'  => $service->id,
            'source_slug' => $service->slug,
            'data'        => $payload, // كل الحقول هنا
            'name'        => $fullName,
            'email'       => $email,
            'phone'       => $phone,
        ]);

        return back()->with('status', 'Tack! Formuläret har skickats.');
    }

    // Helper: يرجع أول قيمة غير فارغة من قائمة مفاتيح محتملة
    private function first(Request $request, array $keys, $default = null)
    {
        foreach ($keys as $k) {
            $v = $request->input($k);
            if (is_string($v)) $v = trim($v);
            if (!empty($v)) return $v;
        }
        return $default;
    }
}

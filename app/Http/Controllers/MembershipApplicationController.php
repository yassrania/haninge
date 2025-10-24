<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class MembershipApplicationController extends Controller
{
    public function create()
    {
        return view('pdf.membership', [
            'showForm'         => true,
            'full_name'        => '',
            'email'            => '',
            'phone'            => '',
            'address'          => '',
            'notes'            => '',
            'signature_base64' => null,
            'signature_path'   => null,
            'submitted_at'     => now()->format('Y-m-d H:i'),
        ]);
    }

    // إرسال كود OTP
    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email'     => ['required','email','max:255'],
            'full_name' => ['nullable','string','max:255'],
        ]);

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $cacheKey = $this->otpCacheKey($request->email, $request->ip());
        Cache::put($cacheKey, $code, now()->addMinutes(10));

        // لو بريدك ما زال محلي وما يرسل فعليًا، على الأقل نخلي الرمز في اللوج
        \Log::info('[OTP] code sent', ['email' => $request->email, 'code' => $code]);

        try {
            Mail::raw(
                "رمز التحقق الخاص بك هو: {$code}\n\nصالح لمدة 10 دقائق.\nHaninge Islamiska Forum",
                function ($msg) use ($request) {
                    $msg->to($request->email)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->subject('رمز التحقق — Haninge Islamiska Forum');
                }
            );
        } catch (\Throwable $e) {
            \Log::error('OTP mail send failed', ['error' => $e->getMessage()]);
              return response()->json(['message' => 'Det gick inte att skicka kod just nu. Försök igen senare.'], 500);        }

        // أثناء التطوير المحلي فقط، أعِد الرمز للمساعدة
        if (app()->isLocal()) {
return response()->json(['message' => 'Kod skickad (lokalt returnerar vi den till dig för testning).', 'dev_otp' => $code]);        }

return response()->json(['message' => 'En verifieringskod har skickats till din e-postadress (giltig i 10 minuter).']);    }

    // حفظ الطلب بعد التحقق من OTP
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'        => ['required','string','max:255'],
            'email'            => ['required','email','max:255'],
            'phone'            => ['nullable','string','max:50'],
            'address'          => ['nullable','string','max:500'],
            'notes'            => ['nullable','string'],
            'signature_base64' => ['nullable','string'],
            'signature'        => ['nullable','image','mimes:png,jpg,jpeg,webp','max:2048'],
            'otp_code'         => ['required','digits:6'],
        ], [
            'otp_code.required' => 'Ange verifieringskoden du fick i posten.',
            'otp_code.digits' => 'Verifieringskoden måste vara 6 siffror lång.',
        ]);

        // تحقق OTP
        $cacheKey = $this->otpCacheKey($request->email, $request->ip());
        $expected = Cache::get($cacheKey);
        if (!$expected || $expected !== $request->otp_code) {
            return back()->withInput()->withErrors(['otp_code' => 'رمز التحقق غير صحيح أو منتهي.']);
        }
        Cache::forget($cacheKey);

        // حفظ التوقيع كملف (أفضل للطباعة)
        $signaturePath = null;
        if (!empty($data['signature_base64']) && str_contains($data['signature_base64'], 'base64,')) {
            $signaturePath = $this->saveBase64SignatureAsFile($data['signature_base64']);
        } elseif ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('signatures', 'public');
        }

        $app = new MembershipApplication();
        $app->full_name      = $data['full_name'];
        $app->email          = $data['email'];
        $app->phone          = $data['phone'] ?? null;
        $app->address        = $data['address'] ?? null;
        $app->notes          = $data['notes'] ?? null;
        $app->signature_path = $signaturePath;
        $app->save();

        return view('pdf.membership', [
            'showForm'         => false,
            'full_name'        => $app->full_name,
            'email'            => $app->email,
            'phone'            => $app->phone,
            'address'          => $app->address,
            'notes'            => $app->notes,
            'signature_base64' => $this->toBase64($signaturePath), // للعرض الفوري
            'signature_path'   => $signaturePath,                   // للطباعة الموثوقة
            'submitted_at'     => optional($app->created_at)->format('Y-m-d H:i'),
        ]);
    }

    // عرض PDF من الإدمن (بالـ model binding)
    public function adminPdf(MembershipApplication $application)
    {
        return view('pdf.membership', [
            'showForm'         => false,
            'full_name'        => $application->full_name,
            'email'            => $application->email,
            'phone'            => $application->phone,
            'address'          => $application->address,
            'notes'            => $application->notes,
            'signature_base64' => $this->toBase64($application->signature_path),
            'signature_path'   => $application->signature_path,
            'submitted_at'     => optional($application->created_at)->format('Y-m-d H:i'),
        ]);
    }

    // عرض PDF بالـ id مباشرة
    public function adminPdfById($id)
    {
        $application = MembershipApplication::findOrFail($id);

        return view('pdf.membership', [
            'showForm'         => false,
            'full_name'        => $application->full_name,
            'email'            => $application->email,
            'phone'            => $application->phone,
            'address'          => $application->address,
            'notes'            => $application->notes,
            'signature_base64' => $this->toBase64($application->signature_path),
            'signature_path'   => $application->signature_path,
            'submitted_at'     => optional($application->created_at)->format('Y-m-d H:i'),
        ]);
    }

    // ===== Helpers =====

    protected function otpCacheKey(string $email, string $ip): string
    {
        return 'otp:email:' . sha1(strtolower($email)) . ':' . $ip;
    }

    protected function saveBase64SignatureAsFile(string $dataUri): ?string
    {
        if (!str_contains($dataUri, 'base64,')) return null;

        [$meta, $content] = explode('base64,', $dataUri, 2);
        $binary = base64_decode($content);

        $ext = 'png';
        if (str_contains($meta, 'image/jpeg')) $ext = 'jpg';
        elseif (str_contains($meta, 'image/webp')) $ext = 'webp';

        $filename = 'signatures/' . Str::uuid() . '.' . $ext;
        Storage::disk('public')->put($filename, $binary);

        return $filename;
    }

    protected function toBase64(?string $path): ?string
    {
        if (!$path) return null;
        $full = Storage::disk('public')->path($path);
        if (!is_file($full)) return null;

        $mime = @mime_content_type($full) ?: 'image/png';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($full));
    }
}

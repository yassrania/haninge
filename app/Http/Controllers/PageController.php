<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

// Models
use App\Models\HomeSetting;
use App\Models\Service;
use App\Models\ServicesPageSetting;
use App\Models\OmIslamSection;
use App\Models\OmMoskenSection;
use App\Models\OmMoskenDonate;
use App\Models\Nyhet;
use App\Models\NyheterSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\StodMoskenSection;
use App\Models\StodMoskenAside;
use Illuminate\Support\Facades\Schema;
use App\Models\Archive;




class PageController extends Controller
{
    /**
     * / — الصفحة الرئيسية
     */
   public function home(): View
{
    $home = HomeSetting::first();

    // آخر 6 أخبار منشورة (الأحدث أولاً)
    $latestNews = Nyhet::published()
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(6)
        ->get(['title','slug','excerpt','image_path','published_at']);

    return view('pages.home', compact('home', 'latestNews'));
}


    /**
     * /tjanster — صفحة اللائحة/التجميع
     * (تعرض جميع الخدمات المنشورة مع بعض الحقول)
     */
     public function tjansterIndex()
    {
        $table = (new Service)->getTable();

        $services = Service::query()
            ->when(Schema::hasColumn($table, 'is_active'), fn($q) => $q->where('is_active', 1))
            ->when(Schema::hasColumn($table, 'published'),  fn($q) => $q->where('published', 1))
            ->orderBy(Schema::hasColumn($table, 'order') ? 'order' : 'id')
            ->get();

        // عندك صفحة الفهرس في resources/views/pages/tjanster.blade.php
        return view('pages.tjanster', compact('services'));
    }

    /** GET /tjanster/{slug} */
   public function tjansterShow(string $slug)
{
    $service = Service::where('slug', $slug)->firstOrFail();
    return view('services.show', compact('service'));
}
    /**
     * /bonetider — صفحة ثابتة
     */
    public function bonetider(): View
    {
        return view('pages.bonetider');
    }

    /**
     * /om-islam — صفحة ديناميكية تُدار من Filament
     * تعرض (Banner / Image+Text / Text) وفق الترتيب (sort)
     */
    public function omIslam(): View
    {
        // نخزّن النتائج 60 دقيقة لتسريع التحميل.
        $sections = Cache::remember('om_islam_sections', 60, function () {
            return OmIslamSection::orderBy('sort')->get();
        });

        return view('pages.om-islam', [
            'sections'        => $sections,
            'pageTitle'       => 'Om Islam',
            'pageDescription' => 'Information och sektioner om Islam från Haninge Islamiska Forum.',
        ]);
    }

    /**
     * /om-mosken — صفحة ثابتة (يمكن لاحقاً جعلها ديناميكية بنفس أسلوب Om Islam)
     */
    public function omMosken(): \Illuminate\View\View
{
    $sections = Cache::remember('om_mosken_sections', 60, fn () =>
        OmMoskenSection::orderBy('sort')->get()
    );

    $donate = Cache::remember('om_mosken_donate', 60, fn () =>
        OmMoskenDonate::first()
    );

    // متغيرات لبلاد
    $hasDonate = (bool)($donate?->enabled);
    $qrImg     = $donate?->qr_path ? \Storage::url($donate->qr_path) : null;
    $dTitle    = $donate?->title;
    $dSub      = $donate?->subtitle;
    $dBody     = $donate?->body;
    $dBtnTxt   = $donate?->button_label;
    $dBtnUrl   = $donate?->button_url;

    return view('pages.om-mosken', compact(
        'sections',
        'hasDonate','qrImg','dTitle','dSub','dBody','dBtnTxt','dBtnUrl'
    ) + [
        'pageTitle'       => 'Om Mosken',
        'pageDescription' => 'Information om moskén och verksamheten.',
    ]);
}

    /**
     * /nyheter — صفحة ثابتة للأخبار/المدونة
     */
   public function nyheter(): \Illuminate\View\View
{
    $banner = NyheterSetting::first();

    // أخبار منشورة بترتيب الأحدث أولاً – صفحها إن تحب لاحقًا
    $nyheter = Nyhet::published()
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get(['id','title','slug','excerpt','image_path','published_at']);

    return view('pages.nyheter', [
        'banner'  => $banner,
        'nyheter' => $nyheter,
        'pageTitle' => 'Nyheter',
        'pageDescription' => 'Senaste nyheter från Haninge Islamiska Forum.',
    ]);
}

public function nyheterShow(Nyhet $nyhet): \Illuminate\View\View
{
    abort_unless($nyhet->published && $nyhet->published_at && $nyhet->published_at->lte(now()), 404);

    return view('news.show', [
        'nyhet' => $nyhet,
        'pageTitle' => $nyhet->title,
        'pageDescription' => str($nyhet->excerpt)->limit(160),
    ]);
}

    /**
     * /kontakt — صفحة ثابتة للتواصل
     */
    public function kontakt(): View
    {
        return view('pages.kontakt');
    }
    public function kontaktSubmit(Request $request): RedirectResponse
{
    // Honey-pot بسيط لمكافحة السبام
    if ($request->filled('website')) {
        return back()->withInput()->with('error', 'Ogiltig begäran.');
    }

    $data = $request->validate([
        'namn'        => ['required','string','max:120'],
        'email'       => ['required','email','max:190'],
        'telefon'     => ['nullable','string','max:50'],
        'amne'        => ['nullable','string','max:190'],
        'meddelande'  => ['required','string','max:8000'],
        'gdpr'        => ['accepted'],
    ], [], [
        'namn'       => 'namn',
        'email'      => 'e-post',
        'telefon'    => 'telefon',
        'amne'       => 'ämne',
        'meddelande' => 'meddelande',
        'gdpr'       => 'GDPR',
    ]);

    ContactMessage::create([
        'name'        => $data['namn'],
        'email'       => $data['email'],
        'phone'       => $data['telefon'] ?? null,
        'subject'     => $data['amne'] ?? null,
        'message'     => $data['meddelande'],
        'consent_at'  => now(),
        'ip'          => $request->ip(),
        'user_agent'  => substr((string) $request->userAgent(), 0, 255),
        'read_at'     => null,
    ]);

    return back()->with('ok', 'Tack! Ditt meddelande har skickats.');
}

    /**
     * /stod-mosken — صفحة ثابتة للدعم
     */
   public function stodMosken(): \Illuminate\View\View
{
    $sections = Cache::remember('stod_mosken_sections', 60, fn () =>
        StodMoskenSection::where('published', true)->orderBy('sort')->get()
    );

    $aside = Cache::remember('stod_mosken_aside', 60, fn () =>
        StodMoskenAside::first()
    );

    return view('pages.stod-mosken', [
        'sections'  => $sections,
        'aside'     => $aside,
        'pageTitle' => 'Stöd moskén',
        'pageDescription' => 'Stöd Haninge Islamiska Forum.',
    ]);
}

    /**
     * نسخة بديلة لعرض صفحة tjänster باستخدام إعدادات الصفحة العامة
     * (إن كنت تستعمل بلوكات/نصوص عامة داخل ServicesPageSetting)
     */
    public function tjanster(): View
    {
        $page = ServicesPageSetting::first();
        return view('pages.tjanster', compact('page'));
    }

    public function arkivIndex()
{
    $archives = Archive::query()
        ->when(Schema::hasColumn('archives','is_active'), fn($q)=>$q->where('is_active', 1))
        ->orderByRaw(Schema::hasColumn('archives','event_date') ? 'event_date desc, id desc' : 'id desc')
        ->paginate(12);

    return view('pages.arkiv', compact('archives'));
}

public function arkivShow(Archive $archive)
{
    if (Schema::hasColumn('archives','is_active') && !$archive->is_active) {
        abort(404);
    }
    return view('pages.arkiv-show', compact('archive'));
}
}


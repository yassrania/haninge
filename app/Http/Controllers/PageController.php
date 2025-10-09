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
    public function tjansterIndex(): View
    {
        $services = Service::query()
            ->where('published', true)
            ->orderBy('title')
            ->get(['title', 'subtitle', 'slug', 'page_banner']);

        return view('pages.tjanster', compact('services'));
    }

    /**
     * /tjanster/{service:slug} — صفحة خدمة مفردة
     * إن وُجد قالب مخصّص داخل resources/views/services/{slug}.blade.php
     * يمكنك في الـBlade استخدام includeIf إن رغبت.
     */
    public function tjansterShow(Service $service): View
    {
        $pillars = (array) optional(HomeSetting::first())->pillars ?? [];
        return view('services.show', compact('service', 'pillars'));
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

    /**
     * /stod-mosken — صفحة ثابتة للدعم
     */
    public function stodMosken(): View
    {
        return view('pages.stod-mosken');
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
}


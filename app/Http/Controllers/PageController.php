<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

// Models
use App\Models\HomeSetting;
use App\Models\Service;
use App\Models\ServicesPageSetting;
use App\Models\OmIslamSection;

class PageController extends Controller
{
    /**
     * / — الصفحة الرئيسية
     */
    public function home(): View
    {
        $home = HomeSetting::first();
        return view('pages.home', compact('home'));
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
    public function omMosken(): View
    {
        return view('pages.om-mosken');
    }

    /**
     * /nyheter — صفحة ثابتة للأخبار/المدونة
     */
    public function nyheter(): View
    {
        return view('pages.nyheter');
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


<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\HomeSetting;
use App\Models\Service;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    // /tjanster — صفحة لائحة/تجميع
    public function tjansterIndex(): View
    {
        $services = Service::query()
            ->where('published', true)
            ->orderBy('title')
            ->get(['title','subtitle','slug','page_banner']);

        return view('tjanster-index', compact('services'));
    }

    // /tjanster/{service:slug} — صفحة خدمة مفردة
    public function tjansterShow(Service $service): View
    {
        $pillars = (array) (HomeSetting::query()->first()->pillars ?? []);
        return view('service', compact('service', 'pillars'));
    }

    // باقي الصفحات...
    public function bonetider(): View { return view('bonetider'); }
    public function omIslam(): View   { return view('om-islam'); }
    public function omMosken(): View  { return view('om-mosken'); }
    public function nyheter(): View   { return view('nyheter'); }
    public function kontakt(): View   { return view('kontakt'); }
    public function stodMosken(): View{ return view('stod-mosken'); }
}

<?php

namespace App\Http\Controllers;

use App\Models\OmIslamSection;
use Illuminate\Support\Facades\Cache;

class OmIslamController extends Controller
{
    public function index()
    {
        // نجلب العناصر مرتَّبة حسب sort
        $sections = Cache::remember('om_islam_sections', 60, function () {
            return OmIslamSection::orderBy('sort')->get();
        });

        // SEO بسيط - تقدر تستخدم Settings عامّة لو عندك
        $pageTitle = 'Om Islam';
        $pageDescription = 'Information och sektioner om Islam från Haninge Islamiska Forum.';

        return view('pages.om-islam', compact('sections', 'pageTitle', 'pageDescription'));
    }
}

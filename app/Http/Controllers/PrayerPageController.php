<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PrayerTime;

class PrayerPageController extends Controller
{
    public function index(Request $request)
    {
        $year  = (int) ($request->query('year', now()->year));
        $month = (int) ($request->query('month', now()->month));

        $start = Carbon::create($year, $month, 1);
        $end   = (clone $start)->endOfMonth();

        $rows = PrayerTime::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('date')
            ->get();

        // 👈 إذا كان ملفك موجود داخل resources/views/pages/bonetider.blade.php
        return view('pages.bonetider', compact('rows','year','month'));
        // لو نقلته إلى resources/views/bonetider.blade.php استبدل السطر السابق بـ:
        // return view('bonetider', compact('rows','year','month'));
    }

    public function home()
{
    $today = PrayerTime::whereDate('date', today())->first();

    return view('home', [
        'today' => $today,
    ]);
}
}

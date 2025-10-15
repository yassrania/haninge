<?php

namespace App\Services;

use App\Models\PrayerTime;
use Illuminate\Support\Facades\Http;

class MyMasjidShareSync
{
    public function syncYear(string $guid, int $year): int
    {
        $url = "https://time.my-masjid.com/sharescreen/{$guid}";
        $html = Http::timeout(20)->get($url)->body();

        // ملاحظة: لو عندهم param للسنة، أضفه هنا. إن لم يوجد، الصفحة غالباً تعرض سنة جارية/مختارة.
        // الفكرة: نبحث داخل HTML عن كل الأسطر التي تحتوي تاريخ + 6 أوقات بنمط hh:mm.

        $count = 0;

        // تقسيم حسب الشهور (إن أمكن)، وإلا نمر على كل الأسطر ونلتقط تواريخ السنة المطلوبة.
        // Regex يلتقط: yyyy-mm-dd أو dd/mm/yyyy أو dd-mm-yyyy + 6 أوقات بصيغة 00:00
        $pattern = '/(?P<date>\b(?:\d{4}-\d{2}-\d{2}|\d{2}[\/\-]\d{2}[\/\-]\d{4})\b).*?(?P<fajr>\d{1,2}:\d{2}).*?(?P<sunrise>\d{1,2}:\d{2}).*?(?P<dhuhr>\d{1,2}:\d{2}).*?(?P<asr>\d{1,2}:\d{2}).*?(?P<maghrib>\d{1,2}:\d{2}).*?(?P<isha>\d{1,2}:\d{2})/is';

        if (preg_match_all($pattern, $html, $m, PREG_SET_ORDER)) {
            foreach ($m as $row) {
                $rawDate = $row['date'];

                // حوّل التاريخ إلى yyyy-mm-dd
                if (preg_match('/^\d{2}[\/\-]\d{2}[\/\-]\d{4}$/', $rawDate)) {
                    // dd-mm-yyyy أو dd/mm/yyyy → yyyy-mm-dd
                    $parts = preg_split('/[\/\-]/', $rawDate);
                    [$dd,$mm,$yyyy] = $parts;
                    $date = sprintf('%04d-%02d-%02d', (int)$yyyy, (int)$mm, (int)$dd);
                } else {
                    $date = $rawDate; // مفترض yyyy-mm-dd
                }

                // فلتر للسنة المطلوبة فقط
                if ((int)substr($date,0,4) !== $year) continue;

                PrayerTime::updateOrCreate(
                    ['date' => $date],
                    [
                        'fajr'     => self::fmt($row['fajr']),
                        'sunrise'  => self::fmt($row['sunrise']),
                        'dhuhr'    => self::fmt($row['dhuhr']),
                        'asr'      => self::fmt($row['asr']),
                        'maghrib'  => self::fmt($row['maghrib']),
                        'isha'     => self::fmt($row['isha']),
                        'mosque_guid' => $guid,
                        'source'   => 'my-masjid-sharescreen',
                    ]
                );
                $count++;
            }
        }

        return $count;
    }

    protected static function fmt(string $t): string
    {
        // توحيد 9:5 → 09:05
        if (preg_match('/^(\d{1,2}):(\d{2})$/', trim($t), $x)) {
            return str_pad($x[1],2,'0',STR_PAD_LEFT) . ':' . $x[2];
        }
        return $t;
    }
}

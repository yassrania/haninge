<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class MyMasjidFetcher
{
    protected string $base;

    public function __construct()
    {
        $this->base = rtrim(env('MYMASJID_BASE', 'https://time.my-masjid.com'), '/');
    }

    /**
     * يجلب جدول شهر واحد من My-Masjid (JSON) عبر endpoint المؤكد:
     * /api/TimingsInfoScreen/GetMasjidTimingsByMonthDay?Day=..&Month=..&GuidId=..
     * يعيد مصفوفة أيام موحّدة: [{date,fajr,sunrise,dhuhr,asr,maghrib,isha}, ...]
     */
    public function fetchMonth(string $guid, int $year, int $month): array
{
    $ref = "{$this->base}/sharescreen/{$guid}";
    $headers = [
        'Accept'            => 'application/json, text/plain, */*',
        'Referer'           => $ref,
        'Origin'            => $this->base,
        'User-Agent'        => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
        'X-Requested-With'  => 'XMLHttpRequest',
    ];

    $url = "{$this->base}/api/TimingsInfoScreen/GetMasjidTimingsByMonthDay";

    $out = [];
    // جرّب لـ 1..31، وتوقّف إذا بدأ السيرفر يرجّع خطأ بعد آخر يوم فعلي
    for ($day = 1; $day <= 31; $day++) {
        $params = ['GuidId' => $guid, 'Month' => $month, 'Day' => $day];

        try {
            $res = Http::withHeaders($headers)->timeout(20)->get($url, $params);
            if (! $res->ok()) {
                // على أول فشل بعد نجاحات سابقة، اعتبر أن الشهر انتهى
                if ($day > 28) break;
                continue;
            }

            if ($month === 1 && $day === 1) {
                @file_put_contents(storage_path('app/mymasjid_last.json.txt'), (string)$res->body());
            }

            $json = $this->safeJson($res);
            if (empty($json)) {
                continue;
            }

            $row = $this->extractDayFromModelJson($json, $year, $month, $day);
            if ($row) {
                $out[] = $row;
            } else {
                // إذا ما في بيانات لليوم (مثلاً يوم غير موجود)، كمِّل
                if ($day > 28) break;
            }
        } catch (\Throwable $e) {
            // على نهاية الشهر ممكن يفشل لأن اليوم غير موجود
            if ($day > 28) break;
            continue;
        }
    }

    return $out;
}

/** يستخرج أوقات يوم واحد من بنية model.salahTimings */
protected function extractDayFromModelJson(array $json, int $year, int $month, int $day): ?array
{
    $m = \Illuminate\Support\Arr::get($json, 'model.salahTimings');
    if (!is_array($m)) return null;

    $getTime = function($arr) {
        // توقّع مصفوفة عناصر فيها salahTime
        if (is_array($arr) && isset($arr[0]['salahTime'])) {
            return $arr[0]['salahTime'];
        }
        return null;
    };

    $fajr    = $getTime($m['fajr']    ?? null);
    $sunrise = $getTime($m['shouruq'] ?? null); // Sunrise
    $dhuhr   = $getTime($m['zuhr']    ?? null);
    $asr     = $getTime($m['asr']     ?? null);
    $maghrib = $getTime($m['maghrib'] ?? null);
    $isha    = $getTime($m['isha']    ?? null);

    // لو كل القيم فاضية، اعتبر ما في بيانات لهذا اليوم
    if (!$fajr && !$sunrise && !$dhuhr && !$asr && !$maghrib && !$isha) {
        return null;
    }

    $fmt = function($t){
        if (!$t) return null;
        if (preg_match('/^(\d{1,2}):(\d{2})/', trim((string)$t), $mm)) {
            return str_pad($mm[1],2,'0',STR_PAD_LEFT).':'.$mm[2];
        }
        return $t;
    };

    return [
        'date'    => sprintf('%04d-%02d-%02d', $year, $month, $day),
        'fajr'    => $fmt($fajr),
        'sunrise' => $fmt($sunrise),
        'dhuhr'   => $fmt($dhuhr),
        'asr'     => $fmt($asr),
        'maghrib' => $fmt($maghrib),
        'isha'    => $fmt($isha),
    ];
}


    /** JSON آمن: يحاول فكّ النص حتى لو كان مزخرفًا أو double-encoded */
    protected function safeJson(Response $res): array
    {
        $json = $res->json();
        if (is_array($json)) return $json;

        $body = (string) $res->body();

        // إزالة BOM
        $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);

        // إزالة مقدّمات شائعة
        $body = ltrim($body);
        $body = preg_replace("/^\)\]\}',?\s*/", '', $body);
        $body = preg_replace("/^while\s*\(1\);\s*/i", '', $body);

        // قصّ حتى أول { أو [
        if (preg_match('/[\{\[]/u', $body, $m, PREG_OFFSET_CAPTURE)) {
            $start = $m[0][1];
            if ($start > 0) $body = substr($body, $start);
        }

        // قصّ من آخر } أو ]
        $lastBrace = max(strrpos($body, '}') ?: -1, strrpos($body, ']') ?: -1);
        if ($lastBrace > 0) $body = substr($body, 0, $lastBrace + 1);

        $decoded = json_decode($body, true);
        if (is_array($decoded)) return $decoded;

        // احتمال JSON داخل string (double-encoded)
        $trimmed = trim($body, "\"'");
        $decoded = json_decode($trimmed, true);
        if (is_string($decoded)) {
            $decoded2 = json_decode($decoded, true);
            if (is_array($decoded2)) return $decoded2;
        } elseif (is_array($decoded)) {
            return $decoded;
        }

        // إزالة trailing commas
        $body2 = preg_replace('/,\s*([\}\]])/m', '$1', $body);
        $decoded = json_decode($body2, true);
        return is_array($decoded) ? $decoded : [];
    }

    /** تطبيع ردّ "الشهر" إلى مصفوفة أيام موحّدة */
    protected function normalize(array $json, int $year, int $month): array
    {
        // مرشّحات سريعة
        $candidates = [
            $json,
            Arr::get($json, 'days'),
            Arr::get($json, 'Days'),
            Arr::get($json, 'data'),
            Arr::get($json, 'Data'),
            Arr::get($json, 'result'),
            Arr::get($json, 'Result'),
            Arr::get($json, (string)$month),
            Arr::get($json, $month),
        ];

        $days = collect($candidates)->first(function ($v) {
            return is_array($v) && !empty($v) && array_is_list($v) && $this->isDayRecord((array)($v[0] ?? []));
        });

        // بحث عميق عند الفشل
        if (!is_array($days)) {
            $days = $this->findDaysArray($json) ?? [];
        }
        if (!is_array($days) || empty($days)) return [];

        $out = [];
        foreach ($days as $d) {
            $row = $this->mapDay((array)$d, $year, $month);
            if ($row) $out[] = $row;
        }
        return $out;
    }

    /** هل السجل يبدو "يومًا"؟ */
    protected function isDayRecord(array $d): bool
    {
        $keys = array_map('strtolower', array_keys($d));
        $hasPrayerKey = (bool) array_intersect($keys, [
            'fajr','fajrtime',
            'sunrise','shuruk','shurooq','shurouq',
            'dhuhr','zuhr','dhuhrtime',
            'asr','asrtime',
            'maghrib','maghribtime',
            'isha','ishatime','esha',
        ]);

        $hasTimeLike  = collect($d)->contains(fn($v) => is_string($v) && preg_match('/^\d{1,2}:\d{2}/', trim((string)$v)));
        return $hasPrayerKey || $hasTimeLike;
    }

    /** ابحث بعمق عن مصفوفة تشبه "أيام الشهر" */
    protected function findDaysArray(mixed $node): ?array
    {
        if (is_array($node)) {
            if (array_is_list($node) && count($node) >= 20 && $this->isDayRecord((array)($node[0] ?? []))) {
                return $node;
            }
            foreach ($node as $v) {
                $found = $this->findDaysArray($v);
                if (is_array($found)) return $found;
            }
        }
        return null;
    }

    /** حوّل سجل اليوم إلى صيغة موحّدة */
    protected function mapDay(array $d, int $fallbackYear, int $fallbackMonth): ?array
    {
        $date = Arr::get($d, 'date') ?? Arr::get($d, 'Date') ?? null;

        if (! $date) {
            $day   = Arr::get($d, 'day') ?? Arr::get($d, 'Day');
            $month = Arr::get($d, 'month') ?? Arr::get($d, 'Month') ?? $fallbackMonth;
            $year  = Arr::get($d, 'year') ?? Arr::get($d, 'Year') ?? $fallbackYear;
            if ($day) {
                $date = sprintf('%04d-%02d-%02d', (int)$year, (int)$month, (int)$day);
            }
        }

        if (! $date) return null;

        $pick = fn($keys) => collect((array)$keys)
            ->map(fn($k)=>Arr::get($d,$k))
            ->first(fn($v)=>!is_null($v));

        $fajr    = $pick(['Fajr','FajrTime','fajr']);
        $sunrise = $pick(['Shuruk','Shurooq','Sunrise','sunrise','Shurouq','shurooq']);
        $dhuhr   = $pick(['Dhuhr','Zuhr','dhuhr','zuhr','DhuhrTime']);
        $asr     = $pick(['Asr','asr','AsrTime']);
        $maghrib = $pick(['Maghrib','maghrib','MaghribTime']);
        $isha    = $pick(['Isha','isha','Esha','esha','IshaTime']);

        $fmt = function($t){
            if (!$t) return null;
            if (preg_match('/^(\d{1,2}):(\d{2})/', trim((string)$t), $m)) {
                return str_pad($m[1],2,'0',STR_PAD_LEFT) . ':' . $m[2];
            }
            return $t;
        };

        return [
            'date'    => substr(str_replace('/','-',$date), 0, 10),
            'fajr'    => $fmt($fajr),
            'sunrise' => $fmt($sunrise),
            'dhuhr'   => $fmt($dhuhr),
            'asr'     => $fmt($asr),
            'maghrib' => $fmt($maghrib),
            'isha'    => $fmt($isha),
        ];
    }
}

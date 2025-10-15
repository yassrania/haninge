<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MyMasjidFetcher;
use App\Models\PrayerTime;

class SyncMyMasjidYear extends Command
{
    protected $signature = 'prayer:sync-mymasjid {guid?} {year=2025}';
    protected $description = 'Sync a full year (12 months) of prayer times from My-Masjid JSON endpoints';

    public function handle(MyMasjidFetcher $fetcher): int
    {
        $guid = $this->argument('guid') ?? env('MYMASJID_GUID');
        $year = (int) $this->argument('year');

        $total = 0;
        for ($m=1; $m<=12; $m++) {
            $this->info("Fetching month $m/$year ...");
            $days = $fetcher->fetchMonth($guid, $year, $m);

            foreach ($days as $r) {
                PrayerTime::updateOrCreate(
                    ['date'    => $r['date']],
                    [
                        'fajr'    => $r['fajr'],
                        'sunrise' => $r['sunrise'],
                        'dhuhr'   => $r['dhuhr'],
                        'asr'     => $r['asr'],
                        'maghrib' => $r['maghrib'],
                        'isha'    => $r['isha'],
                        'mosque_guid' => $guid,
                        'source'  => 'my-masjid-json',
                    ]
                );
                $total++;
            }
            $this->line("  → saved ".count($days)." days.");
        }

        $this->info("Done. Saved $total days for $year.");
        return self::SUCCESS;
    }
}

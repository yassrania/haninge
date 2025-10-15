<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    protected $fillable = [
        'date','fajr','sunrise','dhuhr','asr','maghrib','isha','mosque_guid','source',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}

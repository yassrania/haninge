<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = ['logo','address','phone','email','bankgiro', 'swish_number'];

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('footer_settings'));
        static::deleted(fn () => cache()->forget('footer_settings'));
    }
}

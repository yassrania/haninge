<?php

// app/Models/FooterSetting.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model {
    protected $fillable = [
        'brand_logo','brand_alt','brand_text','address','phone','email',
        'opening_hours','social_links','bottom_text',
    ];
    protected $casts = [
        'opening_hours' => 'array',
        'social_links'  => 'array',
    ];
}

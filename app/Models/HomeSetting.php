<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    // باش يتسجّل كلشي ديال الفورم بلا قيود mass assignment
    protected $guarded = [];

    protected $casts = [
        'slides'            => 'array',
        'goals'             => 'array',
        'pillars'           => 'array',
        'services'          => 'array',
        'show_latest_news'  => 'boolean',
        'latest_news_limit' => 'integer',
    ];
}

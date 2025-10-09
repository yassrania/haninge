<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'hero_mode','hero_video_file','hero_video_url','hero_image','slides',
        'about_title','about_body','about_image',
        'goals','pillars','goals_title','goals_accent',
        'prayer_title','prayer_body','prayer_button_text','prayer_button_url',
        'services_title','services_desc','services',
        'cta_title','cta_subtitle', 'cta_background', 'cta_button_text','cta_button_url',
        'show_latest_news','latest_news_limit',
        'intro_title','intro_accent', 
    ];

    protected $casts = [
        'slides'  => 'array',
        'goals'   => 'array',
        'pillars' => 'array',
        'services'=> 'array',
        'show_latest_news' => 'boolean',
         'latest_news_limit' => 'integer',

    ];
}

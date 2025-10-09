<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesPageSetting extends Model
{
    protected $table = 'services_page_settings';
    protected $guarded = [];

    protected $casts = [
        'cards'            => 'array', // كروت الصورة+نص
        'education_items'  => 'array', // عناصر قسم utbildning
    ];
}

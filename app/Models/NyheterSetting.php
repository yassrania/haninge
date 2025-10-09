<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NyheterSetting extends Model
{
    protected $table = 'nyheter_settings';

    protected $fillable = [
        'banner_path','title','subtitle',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'email',
        'phone',
        'address',
        'logo',
        'social',
    ];

    protected $casts = [
        'social' => 'array', // مهم عشان يتحول JSON إلى مصفوفة
    ];
}

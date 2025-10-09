<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmMoskenSection extends Model
{
    protected $fillable = [
        'type','title','slug','subtitle',
        'banner_path','image_path','image_position',
        'button_label','button_url','content','sort',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];
}

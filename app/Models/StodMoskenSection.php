<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StodMoskenSection extends Model
{
    protected $fillable = [
        'type','sort','title','subtitle','slug','content',
        'image_path','button_label','button_url','image_position',
        'published',
    ];
}

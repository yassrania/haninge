<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StodMoskenAside extends Model
{
    protected $fillable = [
        'title','body','image_path','button_label','button_url','extra_image_path',
    ];
}

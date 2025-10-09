<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmMoskenDonate extends Model
{
    protected $table = 'om_mosken_donate';

    protected $fillable = [
        'enabled','title','subtitle','body',
        'button_label','button_url','qr_path',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}

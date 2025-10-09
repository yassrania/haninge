<?php

namespace App\Models\Inbox;

use Illuminate\Database\Eloquent\Model;

class AdultStudy extends Model
{
    protected $table = 'adult_studies';
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];
}

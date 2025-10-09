<?php

namespace App\Models\Inbox;

use Illuminate\Database\Eloquent\Model;

class ChildStudy extends Model
{
    protected $table = 'child_studies'; 
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];
}

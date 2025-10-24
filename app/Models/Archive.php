<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'title','slug','event_date','images','excerpt','body','is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'images'     => 'array',  // مهم: JSON ⇄ Array
        'is_active'  => 'boolean',
    ];

    // الربط بالمسار عبر السلاج
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

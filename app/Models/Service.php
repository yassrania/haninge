<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = []; // يسمح بكل الحقول

    protected $casts = [
        'service_rows' => 'array',
        'published'    => 'boolean',
    ];

    // توليد slug بسيط إذا بغيتي تستعمله في السييد/الكنترولر
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

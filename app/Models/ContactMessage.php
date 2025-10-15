<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'service_id',
        'source_slug',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'data',
        'consent_at',
        'ip',
        'user_agent',
        'read_at',
    ];

    protected $casts = [
        'data'       => 'array',
        'consent_at' => 'datetime',
        'read_at'    => 'datetime',
    ];
}

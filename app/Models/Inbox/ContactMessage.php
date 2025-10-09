<?php

namespace App\Models\Inbox;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];
}

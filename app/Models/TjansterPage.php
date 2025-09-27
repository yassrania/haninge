<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TjansterPage extends Model
{
    protected $table = 'tjanster_pages';

    protected $guarded = [];

    protected $casts = [
        'service_rows' => 'array',
    ];
}

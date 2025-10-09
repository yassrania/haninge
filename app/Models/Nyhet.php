<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Nyhet extends Model
{
    protected $table = 'nyheter';

    protected $fillable = [
        'title','slug','excerpt','body','image_path',
        'published','published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // سكوب للأخبار المنشورة حديثاً
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('published', true)
                 ->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }
}

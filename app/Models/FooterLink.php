<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
protected $fillable = ['title', 'label', 'url', 'sort', 'footer_link_group_id'];

public function group()
{
    return $this->belongsTo(\App\Models\FooterLinkGroup::class, 'footer_link_group_id');
}
    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('footer_groups'));
        static::deleted(fn () => cache()->forget('footer_groups'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterLinkGroup extends Model
{
    protected $fillable = ['name', 'title'];

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('sort')->orderBy('id');
    }

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('footer_groups'));
        static::deleted(fn () => cache()->forget('footer_groups'));
    }
}

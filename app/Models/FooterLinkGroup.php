<?php

// app/Models/FooterLinkGroup.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterLinkGroup extends Model {
    protected $fillable = ['title','sort'];
    public function links(): HasMany {
        return $this->hasMany(FooterLink::class)->orderBy('sort');
    }
}

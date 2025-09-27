<?php

// app/Models/FooterLink.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FooterLink extends Model {
    protected $fillable = ['footer_link_group_id','label','url','is_external','sort'];
    public function group(): BelongsTo {
        return $this->belongsTo(FooterLinkGroup::class,'footer_link_group_id');
    }
}

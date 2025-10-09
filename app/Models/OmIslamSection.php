<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmIslamSection extends Model
{
   protected $fillable = [
    'type', 'title', 'slug', 'subtitle',
    'banner_path', 'image_path',
    'button_label', 'button_url',
    'content', 'sort', 'image_position', // ⬅️ أضفناها
];


    protected $casts = [
        'sort' => 'integer',
    ];

    // helpers بسيطة
    public function isBanner(): bool     { return $this->type === 'banner'; }
    public function isImageText(): bool  { return $this->type === 'image_text'; }
    public function isTextOnly(): bool   { return $this->type === 'text'; }
}


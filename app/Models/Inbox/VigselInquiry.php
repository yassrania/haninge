<?php

namespace App\Models\Inbox;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class VigselInquiry extends Model
{
    protected $table = 'vigsel_inquiries';

    protected $fillable = [
        'service_id',
        'source_slug',
        'name',
        'email',
        'phone',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * عرض كل الحقول بشكل مسطّح (flat) ليستوعب الـ KeyValueEntry
     * مثال المفتاح: step2.maka.efternamn
     */
    public function getDataFlatAttribute(): array
    {
        return Arr::dot($this->data ?? []);
    }
}

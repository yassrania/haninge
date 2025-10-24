<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'label',
        'route_name',
        'url',
        'parent_id',
        'order',
        'type',        // from 2025_09_21_152317_add_type_to_menus_table.php
        'new_tab',     // open in new tab
        'is_active',
    ];

    protected $casts = [
        'new_tab'   => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        // Order by `order` if it exists, else fallback to id
        $orderCol = Schema::hasColumn($this->getTable(), 'order') ? 'order' : 'id';

        return $this->hasMany(Menu::class, 'parent_id')->orderBy($orderCol);
    }

    /** Only active rows — your table uses `is_active` */
    public function scopeActive($q)
    {
        if (Schema::hasColumn($this->getTable(), 'is_active')) {
            return $q->where('is_active', true);
        }
        return $q;
    }
}

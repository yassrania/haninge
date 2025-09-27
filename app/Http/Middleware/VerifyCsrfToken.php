<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs that should be excluded from CSRF verification.
     * خليه فارغ. ما نحتاجوش نستثنيو livewire/*
     */
    protected $except = [
        // 'livewire/*', // استعمله مؤقتًا فقط للتشخيص إن لزم الأمر
        
    ];
}

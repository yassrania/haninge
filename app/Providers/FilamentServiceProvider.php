<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // حقن الميتا ديال CSRF فبداية <head> ديال لوحات Filament
        FilamentView::registerRenderHook(
            'panels::head.start',
            fn (): string => view('filament.custom-head')->render(),
        );
    }
}

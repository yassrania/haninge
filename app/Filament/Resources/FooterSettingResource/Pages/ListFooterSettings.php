<?php

namespace App\Filament\Resources\FooterSettingResource\Pages;

use App\Filament\Resources\FooterSettingResource;
use App\Models\FooterSetting;
use Filament\Resources\Pages\ListRecords;

class ListFooterSettings extends ListRecords
{
    protected static string $resource = FooterSettingResource::class;

    protected function getHeaderActions(): array
    {
        // ممنوع create، لكن لو ما في سجل، أنشئ واحد تلقائياً
        if (! FooterSetting::query()->exists()) {
            FooterSetting::create([]);
        }
        return [];
    }
}

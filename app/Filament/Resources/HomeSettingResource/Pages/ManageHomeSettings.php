<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use Filament\Resources\Pages\ManageRecords;

class ManageHomeSettings extends ManageRecords
{
    protected static string $resource = HomeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return []; // سجل واحد فقط
    }
}

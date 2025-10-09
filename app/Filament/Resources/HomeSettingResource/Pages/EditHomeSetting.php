<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditHomeSetting extends EditRecord
{
    protected static string $resource = HomeSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record]);
    }

    // Filament v3: لازم public
    public function getBreadcrumbs(): array
    {
        return [];
    }
}

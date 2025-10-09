<?php

namespace App\Filament\Resources\ServicesPageSettingResource\Pages;

use App\Filament\Resources\ServicesPageSettingResource;
use App\Models\ServicesPageSetting;
use Filament\Resources\Pages\EditRecord;

class EditServicesPageSetting extends EditRecord
{
    protected static string $resource = ServicesPageSettingResource::class;

    public function mount($record = null): void
    {
        $record = ServicesPageSetting::firstOrCreate(['id' => 1], []);
        parent::mount($record->getKey());
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

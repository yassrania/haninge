<?php

namespace App\Filament\Resources\ServicesPageSettingResource\Pages;

use App\Filament\Resources\ServicesPageSettingResource;
use App\Models\ServicesPageSetting;
use Filament\Resources\Pages\ListRecords;

class ListServicesPageSettings extends ListRecords
{
    protected static string $resource = ServicesPageSettingResource::class;

    public function mount(): void
    {
        $record = ServicesPageSetting::firstOrCreate(['id' => 1], []);
        $this->redirect(
            static::getResource()::getUrl('edit', ['record' => $record->getKey()])
        );
    }

    protected function getHeaderActions(): array
    {
        return []; // لا أزرار
    }
}

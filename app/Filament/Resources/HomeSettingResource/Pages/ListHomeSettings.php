<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use App\Models\HomeSetting;
use Filament\Resources\Pages\ListRecords;

class ListHomeSettings extends ListRecords
{
    protected static string $resource = HomeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return []; // لا Create
    }

    public function mount(): void
    {
        $record = HomeSetting::firstOrCreate(['id' => 1], []);
        $this->redirect(HomeSettingResource::getUrl('edit', ['record' => $record]));
    }
}

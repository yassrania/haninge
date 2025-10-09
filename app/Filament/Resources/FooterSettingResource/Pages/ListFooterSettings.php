<?php

namespace App\Filament\Resources\FooterSettingResource\Pages;

use App\Filament\Resources\FooterSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFooterSettings extends ListRecords
{
    protected static string $resource = FooterSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }


    public function mount(): void
    {
        $record = \App\Models\FooterSetting::firstOrCreate(['id' => 1], []);
        $this->redirect(\App\Filament\Resources\FooterSettingResource::getUrl('edit', ['record' => $record]));
    }
}
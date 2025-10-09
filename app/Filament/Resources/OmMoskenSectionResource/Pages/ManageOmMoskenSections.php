<?php

namespace App\Filament\Resources\OmMoskenSectionResource\Pages;

use App\Filament\Resources\OmMoskenSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Cache;

class ManageOmMoskenSections extends ManageRecords
{
    protected static string $resource = OmMoskenSectionResource::class;

    protected static ?string $title = 'Om Mosken';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('add')->label('Add')->icon('heroicon-o-plus'),
        ];
    }

    protected function afterCreate(): void { Cache::forget('om_mosken_sections'); }
    protected function afterEdit(): void { Cache::forget('om_mosken_sections'); }
    protected function afterDelete(): void { Cache::forget('om_mosken_sections'); }
}

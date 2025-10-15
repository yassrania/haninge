<?php

namespace App\Filament\Resources\StodMoskenSectionResource\Pages;

use App\Filament\Resources\StodMoskenSectionResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;

class ManageStodMoskenSections extends ManageRecords
{
    protected static string $resource = StodMoskenSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

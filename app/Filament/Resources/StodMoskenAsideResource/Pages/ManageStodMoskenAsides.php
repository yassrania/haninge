<?php

namespace App\Filament\Resources\StodMoskenAsideResource\Pages;

use App\Filament\Resources\StodMoskenAsideResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;

class ManageStodMoskenAsides extends ManageRecords
{
    protected static string $resource = StodMoskenAsideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

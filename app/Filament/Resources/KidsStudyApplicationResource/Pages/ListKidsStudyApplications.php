<?php

namespace App\Filament\Resources\KidsStudyApplicationResource\Pages;

use App\Filament\Resources\KidsStudyApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKidsStudyApplications extends ListRecords
{
    protected static string $resource = KidsStudyApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

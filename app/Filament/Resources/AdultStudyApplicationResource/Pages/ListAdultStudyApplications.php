<?php

namespace App\Filament\Resources\AdultStudyApplicationResource\Pages;

use App\Filament\Resources\AdultStudyApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdultStudyApplications extends ListRecords
{
    protected static string $resource = AdultStudyApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

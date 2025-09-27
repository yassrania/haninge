<?php

namespace App\Filament\Resources\AdultStudyApplicationResource\Pages;

use App\Filament\Resources\AdultStudyApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdultStudyApplication extends ViewRecord
{
    protected static string $resource = AdultStudyApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AdultStudyApplicationResource\Pages;

use App\Filament\Resources\AdultStudyApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdultStudyApplication extends EditRecord
{
    protected static string $resource = AdultStudyApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

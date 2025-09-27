<?php

namespace App\Filament\Resources\KidsStudyApplicationResource\Pages;

use App\Filament\Resources\KidsStudyApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKidsStudyApplication extends EditRecord
{
    protected static string $resource = KidsStudyApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

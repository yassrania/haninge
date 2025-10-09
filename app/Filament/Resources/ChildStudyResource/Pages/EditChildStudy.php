<?php

namespace App\Filament\Resources\ChildStudyResource\Pages;

use App\Filament\Resources\ChildStudyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChildStudy extends EditRecord
{
    protected static string $resource = ChildStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

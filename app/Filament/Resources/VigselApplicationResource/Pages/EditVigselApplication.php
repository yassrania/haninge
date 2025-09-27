<?php

namespace App\Filament\Resources\VigselApplicationResource\Pages;

use App\Filament\Resources\VigselApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVigselApplication extends EditRecord
{
    protected static string $resource = VigselApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

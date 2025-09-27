<?php

namespace App\Filament\Resources\VigselApplicationResource\Pages;

use App\Filament\Resources\VigselApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVigselApplication extends ViewRecord
{
    protected static string $resource = VigselApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

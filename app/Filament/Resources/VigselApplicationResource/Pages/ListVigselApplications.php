<?php

namespace App\Filament\Resources\VigselApplicationResource\Pages;

use App\Filament\Resources\VigselApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVigselApplications extends ListRecords
{
    protected static string $resource = VigselApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

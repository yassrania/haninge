<?php

namespace App\Filament\Resources\TjansterPageResource\Pages;

use App\Filament\Resources\TjansterPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTjansterPages extends ListRecords
{
    protected static string $resource = TjansterPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

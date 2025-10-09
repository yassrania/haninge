<?php

namespace App\Filament\Resources\OmIslamSectionResource\Pages;

use App\Filament\Resources\OmIslamSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOmIslamSections extends ManageRecords
{
    protected static string $resource = OmIslamSectionResource::class;

    protected static ?string $title = 'Om Islam';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('add')
                ->label('Add')
                ->icon('heroicon-o-plus'),
        ];
    }
}

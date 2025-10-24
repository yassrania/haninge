<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListArchives extends ListRecords
{
    protected static string $resource = ArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ny Arkivpost')
                ->icon('heroicon-o-plus-circle')
                ->color('success'),
        ];
    }

    // يجب أن تكون public لتطابق توقيع الأب
    public function getTitle(): string
    {
        return 'Arkivposter';
    }
}

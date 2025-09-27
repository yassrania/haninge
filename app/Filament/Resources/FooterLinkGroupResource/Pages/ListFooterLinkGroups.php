<?php

namespace App\Filament\Resources\FooterLinkGroupResource\Pages;

use App\Filament\Resources\FooterLinkGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFooterLinkGroups extends ListRecords
{
    protected static string $resource = FooterLinkGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

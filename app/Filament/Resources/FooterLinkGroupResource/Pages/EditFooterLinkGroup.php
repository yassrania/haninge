<?php

namespace App\Filament\Resources\FooterLinkGroupResource\Pages;

use App\Filament\Resources\FooterLinkGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFooterLinkGroup extends EditRecord
{
    protected static string $resource = FooterLinkGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

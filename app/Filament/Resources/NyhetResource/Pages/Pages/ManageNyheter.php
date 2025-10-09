<?php

namespace App\Filament\Resources\NyhetResource\Pages;

use App\Filament\Resources\NyhetResource;
use Filament\Resources\Pages\ManageRecords;

class ManageNyheter extends ManageRecords
{
    protected static string $resource = NyhetResource::class;

    protected static ?string $title = 'Nyheter';
}

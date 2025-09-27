<?php

namespace App\Filament\Resources\FooterSettingResource\Pages;

use App\Filament\Resources\FooterSettingResource;
use Filament\Resources\Pages\ManageRecords;

class ManageFooterSettings extends ManageRecords
{
    protected static string $resource = FooterSettingResource::class;

    protected function getHeaderActions(): array
    {
        // ما بغيناش Actions بحال Create جديد لأن خاصنا غير سجل واحد
        return [];
    }
}

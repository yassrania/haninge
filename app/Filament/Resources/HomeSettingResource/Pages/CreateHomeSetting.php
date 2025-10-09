<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use Filament\Resources\Pages\Page;

class CreateHomeSetting extends Page
{
    protected static string $resource = HomeSettingResource::class;

    public function mount(): void
    {
        $this->redirect(HomeSettingResource::getUrl('manage'));
    }
}

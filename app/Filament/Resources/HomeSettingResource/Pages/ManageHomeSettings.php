<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use App\Models\HomeSetting;
use Filament\Resources\Pages\Page;

class ManageHomeSettings extends Page
{
    protected static string $resource = HomeSettingResource::class;

    protected static string $view = 'filament.pages.blank';

    public function mount(): void
    {
        $record = HomeSetting::firstOrCreate(['id' => 1], []);
        $this->redirect(HomeSettingResource::getUrl('edit', ['record' => $record]));
    }
}

<?php

namespace App\Filament\Resources\NyheterSettingResource\Pages;

use App\Filament\Resources\NyheterSettingResource;
use App\Models\NyheterSetting;
use Filament\Resources\Pages\EditRecord;

class EditNyheterSetting extends EditRecord
{
    protected static string $resource = NyheterSettingResource::class;

    public function mount(int|string $record = null): void
    {
        $model = NyheterSetting::first() ?? NyheterSetting::create();
        parent::mount($model->getKey());
    }
}

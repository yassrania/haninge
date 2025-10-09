<?php

namespace App\Filament\Resources\OmMoskenDonateResource\Pages;

use App\Filament\Resources\OmMoskenDonateResource;
use App\Models\OmMoskenDonate;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EditOmMoskenDonate extends EditRecord
{
    protected static string $resource = OmMoskenDonateResource::class;

    public function mount(int|string $record = null): void
    {
        // اجعلها سجلاً وحيدًا (singleton): أنشئ أو استخدم أول سجل
        $model = OmMoskenDonate::first() ?? OmMoskenDonate::create();
        parent::mount($model->getKey());
    }

    protected function afterSave(): void
    {
        Cache::forget('om_mosken_donate');
    }
}

<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditArchive extends EditRecord
{
    protected static string $resource = ArchiveResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Arkivpost uppdaterad';
    }
}

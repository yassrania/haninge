<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateArchive extends CreateRecord
{
    protected static string $resource = ArchiveResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Arkivpost skapad';
    }
}

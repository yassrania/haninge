<?php

namespace App\Filament\Resources\TjansterPageResource\Pages;

use App\Filament\Resources\TjansterPageResource;
use Filament\Resources\Pages\EditRecord;

class EditTjansterPage extends EditRecord
{
    protected static string $resource = TjansterPageResource::class;

    protected function getHeaderActions(): array
    {
        return []; // لا Delete/Create
    }

    public function mount($record = null): void
    {
        // نضمن سجل واحد فقط
        $this->record = $this->resolveRecord(
            $record ?? \App\Models\TjansterPage::firstOrCreate([])->getKey()
        );
        $this->authorizeAccess();
    }
}

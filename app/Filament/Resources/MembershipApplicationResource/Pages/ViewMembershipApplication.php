<?php

namespace App\Filament\Resources\MembershipApplicationResource\Pages;

use App\Filament\Resources\MembershipApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewMembershipApplication extends ViewRecord
{
    protected static string $resource = MembershipApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('skriv_ut_pdf')
                ->label('Skriv ut PDF')
                ->icon('heroicon-o-printer')
                ->url(fn ($record) =>
                    $record->pdf_path
                        ? Storage::disk('public')->url($record->pdf_path)
                        : '#'
                )
                ->openUrlInNewTab()
                ->visible(fn ($record) => (bool) $record->pdf_path),

            // keep the default actions you want here:
            Actions\DeleteAction::make(),
        ];
    }
}

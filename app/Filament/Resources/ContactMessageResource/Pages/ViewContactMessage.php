<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // 👇 يجب أن تكون public
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Avsändare')
                    ->schema([
                        TextEntry::make('name')->label('Namn'),
                        TextEntry::make('email')->label('E-post'),
                        TextEntry::make('phone')->label('Telefon'),
                        TextEntry::make('subject')->label('Ämne'),
                        TextEntry::make('created_at')->label('Skickad')->dateTime(),
                    ])->columns(2),

                Section::make('Meddelande')
                    ->schema([
                        TextEntry::make('message')
                            ->label('Meddelande')
                            ->columnSpanFull()
                            ->markdown(), // أو html() إن تحب
                    ]),
            ]);
    }
}

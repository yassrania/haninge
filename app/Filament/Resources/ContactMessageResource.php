<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\Inbox\ContactMessage;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon  = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Kontaktmeddelanden';
    protected static ?string $pluralModelLabel= 'Kontaktmeddelanden';
    protected static ?string $modelLabel      = 'Kontaktmeddelande';
    protected static ?string $navigationGroup = 'Inkorgar';

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        Section::make('Avsändare')->columns(3)->schema([
            TextEntry::make('name')->label('Namn'),
            TextEntry::make('email')->label('E-post'),
            TextEntry::make('phone')->label('Telefon'),
            TextEntry::make('source_slug')->label('Källa')->badge(),
            TextEntry::make('created_at')->label('Skickad')->dateTime(),
        ]),

        Section::make('Formuläruppgifter')->schema([
            RepeatableEntry::make('data_items')
                ->label('Fält')
                // حوّل data {key:value} إلى [{key, value}, ...]
                ->state(function ($record) {
                    return collect($record->data ?? [])
                        ->map(function ($v, $k) {
                            if (is_array($v) || is_object($v)) {
                                $v = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                            }
                            return ['key' => (string) $k, 'value' => (string) $v];
                        })
                        ->values()
                        ->all();
                })
                ->schema([
                    TextEntry::make('key')->label('Fält'),
                    TextEntry::make('value')->label('Värde')->columnSpan(2),
                ])
                ->columns(3)
                ->columnSpanFull(),
        ])->collapsible(),
    ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Namn')->searchable(),
                TextColumn::make('email')->label('E-post')->searchable(),
                TextColumn::make('phone')->label('Telefon')->searchable(),
                TextColumn::make('source_slug')->label('Källa')->badge(),
                TextColumn::make('created_at')->label('Skickad')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view'  => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}

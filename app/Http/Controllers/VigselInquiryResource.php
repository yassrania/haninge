<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VigselInquiryResource\Pages;
use App\Models\Inbox\VigselInquiry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;

class VigselInquiryResource extends Resource
{
    protected static ?string $model = VigselInquiry::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationLabel = 'Vigsel Inquiries';
    protected static ?string $pluralModelLabel = 'Vigsel Inquiries';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('#'),
                TextColumn::make('name')->label('Namn')->searchable(),
                TextColumn::make('email')->label('E-post')->searchable(),
                TextColumn::make('phone')->label('Telefon')->searchable(),
                TextColumn::make('source_slug')->label('Källa')->badge(),
                TextColumn::make('created_at')->dateTime()->label('Skickad')->sortable(),
            ])
            ->defaultSort('id','desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

   use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        Section::make('Avsändare')->schema([
            TextEntry::make('name')->label('Namn'),
            TextEntry::make('email')->label('E-post'),
            TextEntry::make('phone')->label('Telefon'),
            TextEntry::make('source_slug')->label('Källa'),
            TextEntry::make('created_at')->dateTime()->label('Skickad'),
        ]),

        Section::make('Formuläruppgifter')->schema([
            KeyValueEntry::make('data_flat')
                ->keyLabel('Fält')
                ->valueLabel('Värde')
                ->visible(fn ($record) => !empty($record->data_flat)),
        ])->collapsed(),
    ]);
}

}

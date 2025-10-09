<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdultStudyApplicationResource\Pages;
use App\Filament\Resources\AdultStudyApplicationResource\RelationManagers;
use App\Models\AdultStudyApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class AdultStudyApplicationResource extends Resource
{
  protected static ?string $model = \App\Models\Inbox\AdultStudy::class;
protected static ?string $navigationGroup = 'Inkorgar';
protected static ?string $navigationLabel = 'Vuxenstudier';
protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdultStudyApplications::route('/'),
            'create' => Pages\CreateAdultStudyApplication::route('/create'),
            'view' => Pages\ViewAdultStudyApplication::route('/{record}'),
            'edit' => Pages\EditAdultStudyApplication::route('/{record}/edit'),
        ];
    }
}

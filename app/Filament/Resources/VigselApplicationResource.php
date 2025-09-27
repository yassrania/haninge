<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VigselApplicationResource\Pages;
use App\Filament\Resources\VigselApplicationResource\RelationManagers;
use App\Models\VigselApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VigselApplicationResource extends Resource
{
    protected static ?string $model = VigselApplication::class;
protected static ?string $navigationGroup = 'Inkorgar';
protected static ?string $navigationLabel = 'Vigselförfrågningar';
protected static ?string $navigationIcon = 'heroicon-o-heart';
protected static ?int $navigationSort = 10;
   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ables\Columns\TextColumn::make('first_name')->label('Förnamn')->searchable(),
        Tables\Columns\TextColumn::make('last_name')->label('Efternamn')->searchable(),
        Tables\Columns\TextColumn::make('email')->label('E-post'),
        Tables\Columns\TextColumn::make('requested_date')->date()->label('Önskat datum'),
        Tables\Columns\IconColumn::make('handled')->boolean()->label('Hanterad'),
        Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d H:i')->label('Mottaget'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('toggleHandled')
            ->label('Växla hanterad')
            ->action(fn($record) => $record->update(['handled' => ! $record->handled])),
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
            'index' => Pages\ListVigselApplications::route('/'),
            'create' => Pages\CreateVigselApplication::route('/create'),
            'view' => Pages\ViewVigselApplication::route('/{record}'),
            'edit' => Pages\EditVigselApplication::route('/{record}/edit'),
        ];
    }
}

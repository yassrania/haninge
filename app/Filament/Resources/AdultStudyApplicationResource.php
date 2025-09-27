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

class AdultStudyApplicationResource extends Resource
{
    protected static ?string $model = AdultStudyApplication::class;
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

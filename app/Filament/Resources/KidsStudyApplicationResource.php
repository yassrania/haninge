<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KidsStudyApplicationResource\Pages;
use App\Filament\Resources\KidsStudyApplicationResource\RelationManagers;
use App\Models\KidsStudyApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KidsStudyApplicationResource extends Resource
{
    protected static ?string $model = KidsStudyApplication::class;
// app/Filament/Resources/KidsStudyApplicationResource.php
protected static ?string $navigationGroup = 'Inkorgar';
protected static ?string $navigationLabel = 'Barnstudier';
protected static ?string $navigationIcon = 'heroicon-o-user-group';
protected static ?int $navigationSort = 30;


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
            'index' => Pages\ListKidsStudyApplications::route('/'),
            'create' => Pages\CreateKidsStudyApplication::route('/create'),
            'view' => Pages\ViewKidsStudyApplication::route('/{record}'),
            'edit' => Pages\EditKidsStudyApplication::route('/{record}/edit'),
        ];
    }
}

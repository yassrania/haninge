<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterLinkGroupResource\Pages;
use App\Filament\Resources\FooterLinkGroupResource\RelationManagers\LinksRelationManager;
use App\Models\FooterLinkGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterLinkGroupResource extends Resource
{
    protected static ?string $model = FooterLinkGroup::class;

    protected static ?string $navigationGroup = 'Footer';
    protected static ?string $navigationLabel = 'Footer Link Groups';
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Gruppnamn (t.ex. "Våra tjänster")')
                ->required()
                ->maxLength(100),
                Forms\Components\TextInput::make('title')
                ->label('Titel')
                ->required(),   // مهم لأنه NOT NULL في الداتابيس
        ])
        ->columns(2); 
       
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Grupp')->searchable(),
                Tables\Columns\TextColumn::make('links_count')->counts('links')->label('Antal länkar'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            LinksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooterLinkGroups::route('/'),
            'create' => Pages\CreateFooterLinkGroup::route('/create'),
            'edit' => Pages\EditFooterLinkGroup::route('/{record}/edit'),
        ];
    }
}

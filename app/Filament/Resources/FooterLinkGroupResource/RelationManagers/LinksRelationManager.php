<?php

namespace App\Filament\Resources\FooterLinkGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LinksRelationManager extends RelationManager
{
    // اسم العلاقة في موديل FooterLinkGroup
    protected static string $relationship = 'links';

   public function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('title')
            ->label('Titel')
            ->required()
            ->maxLength(150),

        Forms\Components\TextInput::make('url')
            ->label('Länk')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('sort')
            ->label('Sortering')
            ->numeric()
            ->default(0),

        // مهم: نحفظ label تلقائياً = title
        Forms\Components\TextInput::make('label')
            ->dehydrated(true)
            ->default(fn (Forms\Get $get) => $get('title'))
            ->hidden(),
    ])->columns(2);
}

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titel')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('url')->label('Länk')->limit(40),
                Tables\Columns\TextColumn::make('sort')->label('Sortering')->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->reorderable('sort'); // إذا تريد سحب-وأفلت حسب sort
    }
}

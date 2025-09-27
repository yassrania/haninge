<?php

namespace App\Filament\Resources\FooterLinkGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LinksRelationManager extends RelationManager
{
    // اسم العلاقة كما هو مذكور في موديل FooterLinkGroup
    protected static string $relationship = 'links';

    protected static ?string $title = 'Länkar';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')
                ->label('Etikett')
                ->required(),

            Forms\Components\TextInput::make('url')
                ->label('URL / Route')
                ->required()
                ->helperText('Kan vara full URL eller ett internt path/route.'),

            Forms\Components\Toggle::make('is_external')
                ->label('Extern länk?')
                ->default(false),

            Forms\Components\TextInput::make('sort')
                ->label('Sortering')
                ->numeric()
                ->default(0),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Etikett')
                    ->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_external')
                    ->label('Extern')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('Sortering')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}

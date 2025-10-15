<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StodMoskenAsideResource\Pages;
use App\Models\StodMoskenAside;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StodMoskenAsideResource extends Resource
{
    protected static ?string $model = StodMoskenAside::class;

    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Stöd – Sidokolumn';
    protected static ?string $modelLabel      = 'Stöd – Sidokolumn';
    protected static ?string $pluralModelLabel= 'Stöd – Sidokolumn';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Titel')->required(),
            Forms\Components\RichEditor::make('body')
                ->label('Text')
                ->toolbarButtons(['bold','italic','underline','h2','blockquote','link','orderedList','unorderedList'])
                ->required(),

            Forms\Components\FileUpload::make('image_path')
                ->label('Bild')
                ->image()
                ->directory('stod'),

            Forms\Components\TextInput::make('button_label')->label('Knapptext'),
            Forms\Components\TextInput::make('button_url')->label('Knapp-URL')->url(),

            Forms\Components\FileUpload::make('extra_image_path')
                ->label('Extra bild')
                ->image()
                ->directory('stod'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titel')->limit(40)->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Uppdaterad')->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStodMoskenAsides::route('/'),
        ];
    }
}

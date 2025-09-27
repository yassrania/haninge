<?php

// app/Filament/Resources/FooterSettingResource.php
namespace App\Filament\Resources;
use App\Filament\Resources\FooterLinkGroupResource\RelationManagers\LinksRelationManager;

use App\Filament\Resources\FooterSettingResource\Pages;
use App\Models\FooterSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterSettingResource extends Resource
{
    protected static ?string $model = FooterSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Footer-inställningar';
    protected static ?string $navigationGroup = 'Webbplats';
    protected static ?string $modelLabel = 'Footer-inställningar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Varumärke')->schema([
                Forms\Components\FileUpload::make('brand_logo')->label('Logotyp (vit)')
                    ->image()->directory('settings')->disk('public')
                    ->openable()->downloadable()->deletable(),
                Forms\Components\TextInput::make('brand_alt')->label('Alt-text')->required(),
                Forms\Components\Textarea::make('brand_text')->label('Kort beskrivning')->rows(3),
            ])->columns(2),

            Forms\Components\Section::make('Kontakt')->schema([
                Forms\Components\TextInput::make('address')->label('Adress'),
                Forms\Components\TextInput::make('phone')->label('Telefon'),
                Forms\Components\TextInput::make('email')->label('E-post')->email(),
            ])->columns(3),

            Forms\Components\Section::make('Öppettider')->schema([
                Forms\Components\Repeater::make('opening_hours')->label('Rader')->schema([
                    Forms\Components\TextInput::make('label')->label('Dag / period')->required(),
                    Forms\Components\TextInput::make('value')->label('Tid')->required(),
                ])->columns(2)->default([]),
            ]),

            Forms\Components\Section::make('Sociala medier')->schema([
                Forms\Components\Repeater::make('social_links')->label('Länkar')->schema([
                    Forms\Components\TextInput::make('platform')->label('Plattform'),
                    Forms\Components\TextInput::make('url')->label('URL')->url(),
                ])->default([]),
            ]),

            Forms\Components\Section::make('Sidfot längst ned')->schema([
                Forms\Components\TextInput::make('bottom_text')
                    ->label('Nedre text (©)')
                    ->placeholder('© '.date('Y').' Haninge Islamiska Forum. Alla rättigheter förbehållna.'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('email')->label('E-post'),
            Tables\Columns\TextColumn::make('updated_at')->label('Uppdaterad')->dateTime(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFooterSettings::route('/'),
        ];
    }
    public static function getRelations(): array
{
    return [
        LinksRelationManager::class,
    ];
}

}

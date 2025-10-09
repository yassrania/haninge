<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NyheterSettingResource\Pages;
use App\Models\NyheterSetting;
use Filament\Forms\Form;
use Filament\Forms\Components\{FileUpload, TextInput, Section};
use Filament\Resources\Resource;

class NyheterSettingResource extends Resource
{
    protected static ?string $model = NyheterSetting::class;

    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationLabel = 'Nyheter – Banner';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Banner')->columns(2)->schema([
                FileUpload::make('banner_path')->label('Banner')->image()
                    ->directory('nyheter/banners')->preserveFilenames(),
                TextInput::make('title')->label('Titel'),
                TextInput::make('subtitle')->label('Undertitel'),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [ 'index' => Pages\EditNyheterSetting::route('/') ];
    }
}

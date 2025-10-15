<?php

namespace App\Filament\Resources;

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

    protected static ?string $navigationGroup = 'Footer';
    protected static ?string $navigationLabel = 'Footer Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?int $navigationSort = 10;

    public static function canCreate(): bool
    {
        // سجل واحد فقط
        return false;
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\FileUpload::make('logo')
                ->label('Logotyp')
                ->disk('public')
                ->directory('footer')
                ->image()
                ->openable()
                ->downloadable()
                ->deletable(),

            Forms\Components\TextInput::make('address')
                ->label('Adress')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('phone')
                ->label('Telefon'),

            Forms\Components\TextInput::make('email')
                ->label('E-post')
                ->email(),

            Forms\Components\TextInput::make('bankgiro')
                ->label('Bankgiro')
                ->placeholder('t.ex. 123 580 31 19')
                ->maxLength(50),

            Forms\Components\TextInput::make('swish_number')
                ->label('Swish')
                ->placeholder('t.ex. 123 456 78 90')
                ->maxLength(50),
        ])
        ->columns(2);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square()
                    ->height(40),
               Tables\Columns\TextColumn::make('address')->label('Adress')->limit(40),
            Tables\Columns\TextColumn::make('phone')->label('Telefon'),
            Tables\Columns\TextColumn::make('email')->label('E-post'),
            Tables\Columns\TextColumn::make('bankgiro')->label('Bankgiro'),
            Tables\Columns\TextColumn::make('swish_number')->label('Swish'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooterSettings::route('/'),
            'edit'  => Pages\EditFooterSetting::route('/{record}/edit'),
        ];
    }
}

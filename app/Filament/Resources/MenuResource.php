<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Innehåll';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')
                ->label('Label')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('route')
                ->label('Route name')
                ->helperText('t.ex. services.index'),

            Forms\Components\TextInput::make('url')
                ->label('URL')
                ->helperText('Används om ingen route'),

            Forms\Components\Select::make('parent_id')
                ->label('Parent')
                ->relationship('parent', 'label')
                ->searchable()
                ->preload()
                ->native(false),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0)
                ->label('Order'),

            Forms\Components\Select::make('type')
                ->label('Typ')
                ->options([
                    'link' => 'Länk',
                    'cta'  => 'Call to action',
                ])
                ->default('link'),

            Forms\Components\Toggle::make('new_tab')
                ->label('Öppna i ny flik')
                ->default(false),

            Forms\Components\Toggle::make('is_active')
                ->label('Aktiv')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order') // drag & drop
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Parent')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('route')
                    ->label('Route')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Typ')
                    ->colors([
                        'primary' => 'link',
                        'success' => 'cta',
                    ]),

                Tables\Columns\IconColumn::make('new_tab')
                    ->label('Ny flik')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktiv')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'label'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktiv'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit'   => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}

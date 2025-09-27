<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationGroup = 'Innehåll';
    protected static ?string $navigationLabel = 'Tjänstsidor';
    protected static ?string $modelLabel       = 'Tjänstsida';
    protected static ?string $navigationIcon   = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        $urlRule = ['nullable', 'regex:/^(\/|#|https?:\/\/)[^\s]+$/'];

        return $form->schema([
            Forms\Components\Section::make('Sidhuvud')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titel')
                    ->required()
                    ->maxLength(160)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, Get $get) {
                        if (!$get('slug')) $set('slug', Str::slug($state));
                    }),

                Forms\Components\TextInput::make('subtitle')
                    ->label('Undertitel')
                    ->maxLength(180),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->helperText('ex: islamisk-begravning')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(180),
            ])->columns(3),

            Forms\Components\Section::make('Page banner')->schema([
                Forms\Components\FileUpload::make('page_banner')
                    ->label('Banner-bild')
                    ->directory('services/page')
                    ->disk('public')
                    ->image(),
            ]),

            Forms\Components\Section::make('Service-rader (1–4)')->schema([
                Forms\Components\Repeater::make('service_rows')
                    ->label('Rader')
                    ->minItems(1)->maxItems(4)
                    ->reorderable(true)
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto')
                            ->directory('services/rows')
                            ->disk('public')
                            ->image()
                            ->panelLayout('compact'),

                        Forms\Components\TextInput::make('title')
                            ->label('Titel')
                            ->maxLength(160),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Undertitel')
                            ->maxLength(180),

                        Forms\Components\Textarea::make('description')
                            ->label('Beskrivning')
                            ->rows(8)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]),

            Forms\Components\Section::make('Utbildning – Vuxna')->schema([
                Forms\Components\FileUpload::make('utbildning_vuxna_photo')
                    ->label('Foto (Vuxna)')
                    ->directory('services/utbildning')
                    ->disk('public')
                    ->image(),
                Forms\Components\TextInput::make('utbildning_vuxna_title')
                    ->label('Titel (Vuxna)')
                    ->maxLength(160),
                Forms\Components\Textarea::make('utbildning_vuxna_desc')
                    ->label('Beskrivning (Vuxna)')
                    ->rows(8)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Utbildning – Barn')->schema([
                Forms\Components\FileUpload::make('utbildning_barn_photo')
                    ->label('Foto (Barn)')
                    ->directory('services/utbildning')
                    ->disk('public')
                    ->image(),
                Forms\Components\TextInput::make('utbildning_barn_title')
                    ->label('Titel (Barn)')
                    ->maxLength(160),
                Forms\Components\Textarea::make('utbildning_barn_desc')
                    ->label('Beskrivning (Barn)')
                    ->rows(8)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Toggle::make('published')
                ->label('Publicerad')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titel')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->copyable(),
                Tables\Columns\IconColumn::make('published')->label('Status')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->label('Uppdaterad')->since(),
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
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}

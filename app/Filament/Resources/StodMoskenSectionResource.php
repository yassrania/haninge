<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StodMoskenSectionResource\Pages;
use App\Models\StodMoskenSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StodMoskenSectionResource extends Resource
{
    protected static ?string $model = StodMoskenSection::class;

    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationIcon  = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'Stöd – Block';
    protected static ?string $modelLabel      = 'Stöd – Block';
    protected static ?string $pluralModelLabel= 'Stöd – Block';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('type')
                    ->label('Typ')
                    ->options([
                        'image'      => 'Image',
                        'image_text' => 'Image + Text',
                        'text'       => 'Text',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('title')->label('Titel'),
                Forms\Components\TextInput::make('subtitle')->label('Undertitel'),
                Forms\Components\TextInput::make('slug')->label('Slug'),
                Forms\Components\Toggle::make('published')->label('Publicerad')->default(true),
                Forms\Components\TextInput::make('sort')->numeric()->default(0)->label('Sortering'),
            ]),

            Forms\Components\Section::make('Innehåll')
                ->collapsible()
                ->collapsed(false)
                ->columnSpanFull()
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Bild')
                        ->image()
                        ->directory('stod')
                        ->visible(fn (Get $get) => in_array($get('type'), ['image','image_text'], true))
                        ->required(fn (Get $get) => in_array($get('type'), ['image','image_text'], true)),

                    Forms\Components\Select::make('image_position')
                        ->label('Bildposition')
                        ->options([
                            'left'  => 'Vänster',
                            'right' => 'Höger',
                        ])
                        ->default('left')
                        ->visible(fn (Get $get) => $get('type') === 'image_text'),

                    Forms\Components\RichEditor::make('content')
                        ->label('Text')
                        ->toolbarButtons(['bold','italic','underline','h2','blockquote','link','orderedList','unorderedList'])
                        ->visible(fn (Get $get) => in_array($get('type'), ['image_text','text'], true))
                        ->required(fn (Get $get) => in_array($get('type'), ['image_text','text'], true)),

                    Forms\Components\TextInput::make('button_label')
                        ->label('Knapptext')
                        ->visible(fn (Get $get) => in_array($get('type'), ['image','image_text'], true)),

                    Forms\Components\TextInput::make('button_url')
                        ->label('Knapp-URL')
                        ->url()
                        ->visible(fn (Get $get) => in_array($get('type'), ['image','image_text'], true)),

                    Forms\Components\FileUpload::make('extra_image_path')
                        ->label('Extra bild')
                        ->image()
                        ->directory('stod')
                        ->visible(fn (Get $get) => $get('type') === 'image'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Typ')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'image'      => 'Image',
                        'image_text' => 'Image + Text',
                        'text'       => 'Text',
                        default      => (string) $state,
                    }),

                Tables\Columns\TextColumn::make('title')->label('Titel')->limit(40)->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->limit(40)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('published')->label('Publicerad'),
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
            'index' => Pages\ManageStodMoskenSections::route('/'),
        ];
    }
}

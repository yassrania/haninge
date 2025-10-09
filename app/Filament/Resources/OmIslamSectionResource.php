<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OmIslamSectionResource\Pages;
use App\Models\OmIslamSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Select, FileUpload, RichEditor, Grid, Section};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\{CreateAction, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};

use Illuminate\Support\Str;

class OmIslamSectionResource extends Resource
{
    protected static ?string $model = OmIslamSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationLabel = 'Om Islam';
    protected static ?string $pluralModelLabel = 'Om Islam';
    protected static ?string $modelLabel = 'Om Islam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Typ & Grunddata')
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->label('Typ')
                            ->options([
                                'banner'     => 'Banner',
                                'image_text' => 'Image + Text',
                                'text'       => 'Text',
                            ])
                            ->required()
                            ->reactive(),

                        TextInput::make('title')
                            ->label('Title')
                            ->maxLength(150)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // لو النوع Banner بس هو اللي محتاج slug مؤكد
                                if (blank($get('slug')) && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(150)
                            ->unique(ignoreRecord: true)
                            ->helperText('يُستخدم للرابط (خاصةً للـ Banner).')
                            ->visible(fn ($get) => $get('type') === 'banner'),
                    ]),

                // Banner fields
                Section::make('Banner')
                    ->columns(2)
                    ->visible(fn ($get) => $get('type') === 'banner')
                    ->schema([
                        FileUpload::make('banner_path')
                            ->label('Banner')
                            ->image()
                            ->directory('om-islam/banners')
                            ->preserveFilenames()
                            ->required(),

                        TextInput::make('title')
                            ->label('Title')
                            ->maxLength(150),
                    ]),

                // Image + Text fields
              Section::make('Image + Text')
    ->columns(2)
    ->visible(fn ($get) => $get('type') === 'image_text')
    ->schema([
        FileUpload::make('image_path')
            ->label('Image')
            ->image()
            ->directory('om-islam/images')
            ->preserveFilenames()
            ->required(),

        Grid::make(1)->schema([
            TextInput::make('title')
                ->label('Title')
                ->maxLength(150),

            TextInput::make('subtitle')
                ->label('Undertitle')
                ->maxLength(200),

            // Rich text content
            RichEditor::make('content')
                ->label('Text')
                ->toolbarButtons([
                    'bold','italic','underline','strike',
                    'h2','h3','blockquote','orderedList','bulletList',
                    'link','undo','redo',
                ])
                ->columnSpanFull(),

            // Button Läs mer
            TextInput::make('button_label')
                ->label('Button (t.ex. “Läs mer”)')
                ->default('Läs mer')
                ->maxLength(50),

            TextInput::make('button_url')
                ->label('URL')
                ->url()
                ->maxLength(255),

            // Bild position
            Select::make('image_position')
                ->label('Bildposition')
                ->options([
                    'left'  => 'Vänster',
                    'right' => 'Höger',
                ])
                ->default('left')
                ->native(false),
        ]),
    ]),


                // Text only fields
                Section::make('Text')
                    ->columns(1)
                    ->visible(fn ($get) => $get('type') === 'text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->maxLength(150),

                        TextInput::make('subtitle')
                            ->label('Undertitle')
                            ->maxLength(200),

                        RichEditor::make('content')
                            ->label('Text')
                            ->toolbarButtons([
                                'bold','italic','underline','strike',
                                'h2','h3','blockquote','orderedList','bulletList',
                                'link','undo','redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort') // سحب وإفلات
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('type')
                    ->label('Typ')
                    ->formatStateUsing(fn ($state) => [
                        'banner' => 'Banner',
                        'image_text' => 'Image + Text',
                        'text' => 'Text',
                    ][$state] ?? $state)
                    ->badge(),

                TextColumn::make('title')
                    ->label('Title')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Uppdaterad')
                    ->since(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                // زر Add يفتح فورم الإنشاء مع اختيار النوع
                CreateAction::make('add')
                    ->label('Add')
                    ->icon('heroicon-o-plus'),
              
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOmIslamSections::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicesPageSettingResource\Pages;
use App\Models\ServicesPageSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Components
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class ServicesPageSettingResource extends Resource
{
    protected static ?string $model = ServicesPageSetting::class;

    protected static ?string $navigationIcon   = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel  = 'Tjänster (sida)';
    protected static ?string $pluralModelLabel = 'Tjänster (sida)';
    protected static ?string $modelLabel       = 'Tjänster (sida)';
    protected static ?string $navigationGroup  = 'Sajtinställningar';
    protected static ?string $slug             = 'services-page-settings';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Services Page')->tabs([

                // =============== BANNER ===============
                Tab::make('Banner')->schema([
                    FileUpload::make('banner')
                        ->label('Banner-bild')
                        ->disk('public')
                        ->directory('services-page/banner')
                        ->image()
                        ->openable()
                        ->downloadable()
                        ->preserveFilenames()
                        ->nullable(),

                    TextInput::make('title')
                        ->label('Huvudrubrik')
                        ->maxLength(255)
                        ->nullable(),

                    TextInput::make('subtitle')
                        ->label('Undertitel')
                        ->maxLength(255)
                        ->nullable(),
                ])->columns(2),

                // =============== KORT (Cards Section) ===============
                Tab::make('Kort')->schema([
                    TextInput::make('cards_section_title')
                        ->label('Sektionstitel (Kort)')
                        ->placeholder('Våra tjänster')
                        ->maxLength(255)
                        ->nullable(),

                    TextInput::make('cards_section_subtitle')
                        ->label('Undertitel (Kort)')
                        ->maxLength(255)
                        ->nullable(),

                    // ملاحظة: يجب أن يكون لديك عمود cards_section_description في الجدول
                    RichEditor::make('cards_section_description')
                        ->label('Beskrivning (Kort)')
                        ->toolbarButtons([
                            'bold','italic','underline','link',
                            'bulletList','orderedList','undo','redo',
                        ])
                        ->columnSpanFull()
                        ->nullable(),

                    Repeater::make('cards')
                        ->label('Kort – Lista')
                        ->schema([

                            FileUpload::make('image')
                                ->label('Bild')
                                ->disk('public')
                                ->directory('services-page/cards')
                                ->image()
                                ->openable()
                                ->downloadable()
                                ->preserveFilenames()
                                ->nullable(),

                            Select::make('image_position')
                                ->label('Bild position')
                                ->options([
                                    'left'  => 'Vänster',
                                    'right' => 'Höger',
                                ])
                                ->placeholder('Välj position')
                                ->native(false)
                                ->default('left'),

                            TextInput::make('title')
                                ->label('Titel')
                                ->maxLength(255)
                                ->required(),

                            TextInput::make('subtitle')
                                ->label('Undertitel')
                                ->maxLength(255)
                                ->nullable(),

                            RichEditor::make('body')
                                ->label('Beskrivning')
                                ->columnSpanFull()
                                ->nullable(),

                            TextInput::make('button_text')
                                ->label('Knapptitel')
                                ->maxLength(120)
                                ->nullable(),

                            TextInput::make('button_url')
                                ->label('Knapp URL')
                                ->url()
                                ->nullable(),
                        ])
                        ->collapsed()
                        ->addActionLabel('Lägg till kort')
                        ->itemLabel(fn (array $state): string => $state['title'] ?? 'Kort')
                        ->columnSpanFull(),
                ])->columns(2),

                // =============== UTBILDNING ===============
                Tab::make('Utbildning')->schema([
                    TextInput::make('education_title')
                        ->label('Sektionstitel (Utbildning)')
                        ->placeholder('Utbildning')
                        ->maxLength(255)
                        ->nullable(),

                    // ملاحظة: يجب أن تكون قد أضفت هذين العمودين بالـ migrations
                    TextInput::make('education_subtitle')
                        ->label('Undertitel (Utbildning)')
                        ->maxLength(255)
                        ->nullable(),

                    RichEditor::make('education_description')
                        ->label('Beskrivning (Utbildning)')
                        ->toolbarButtons([
                            'bold','italic','underline','link',
                            'bulletList','orderedList','undo','redo',
                        ])
                        ->columnSpanFull()
                        ->nullable(),

                    Repeater::make('education_items')
                        ->label('Utbildning – Poster')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Bild')
                                ->disk('public')
                                ->directory('services-page/education')
                                ->image()
                                ->openable()
                                ->downloadable()
                                ->preserveFilenames()
                                ->nullable(),

                            TextInput::make('title')
                                ->label('Titel')
                                ->maxLength(255)
                                ->required(),

                            TextInput::make('subtitle')
                                ->label('Undertitel')
                                ->maxLength(255)
                                ->nullable(),

                            RichEditor::make('body')
                                ->label('Beskrivning')
                                ->columnSpanFull()
                                ->nullable(),

                            TextInput::make('button_text')
                                ->label('Knapptitel')
                                ->maxLength(120)
                                ->nullable(),

                            TextInput::make('button_url')
                                ->label('Knapp URL')
                                ->url()
                                ->nullable(),
                        ])
                        ->collapsed()
                        ->addActionLabel('Lägg till post')
                        ->itemLabel(fn (array $state): string => $state['title'] ?? 'Post')
                        ->columnSpanFull(),
                ])->columns(2),

            ])->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        // جدول بسيط لتفادي أخطاء داخلية
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Titel')->limit(40),
                Tables\Columns\TextColumn::make('updated_at')->label('Uppdaterad')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicesPageSettings::route('/'),
            'edit'  => Pages\EditServicesPageSetting::route('/{record}/edit'),
        ];
    }

    // Singleton: منع CRUD إضافي
    public static function canCreate(): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canReplicate($record): bool { return false; }
    public static function canForceDelete($record): bool { return false; }
}

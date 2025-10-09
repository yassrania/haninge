<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSettingResource\Pages;
use App\Models\HomeSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;

class HomeSettingResource extends Resource
{
    protected static ?string $model = HomeSetting::class;

    protected static ?string $navigationIcon   = 'heroicon-o-home';
    protected static ?string $navigationLabel  = 'Startsida';
    protected static ?string $pluralModelLabel = 'Startsida';
    protected static ?string $modelLabel       = 'Startsida';
    protected static ?string $navigationGroup  = 'Sajtinställningar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Startsida')->tabs([

                // ================= HERO =================
               // ================= HERO =================

// ================= HERO =================
Tab::make('Hero')->schema([
    Forms\Components\Select::make('hero_mode')
        ->label('Hero-läge')
        ->options([
            'image_slider' => 'Image Slider',
            'video_slider' => 'Video Slider',
            'single_image' => 'Single Image',
        ])
        ->required()
        ->native(false)
        ->columnSpanFull(),

    // صورة واحدة لو اخترت Single Image
    FileUpload::make('hero_image')
        ->label('Hero-bild')
        ->disk('public')
        ->directory('home/hero')
        ->visibility('public')
        ->preserveFilenames()
        ->image()
        ->maxSize(4096)
        ->openable()
        ->downloadable()
        ->visible(fn (Get $get) => $get('hero_mode') === 'single_image')
        ->nullable(),

    // الـ Slides: الحقول تتغير حسب الوضع
    Repeater::make('slides')
        ->label('Slides')
        ->schema([
            // عند Image Slider: صورة فقط
            FileUpload::make('image')
                ->label('Bild (Image Slide)')
                ->disk('public')
                ->directory('home/hero/slides')
                ->visibility('public')
                ->preserveFilenames()
                ->image()
                ->maxSize(8192)
                ->openable()
                ->downloadable()
                ->visible(fn (Get $get) => $get('../../hero_mode') === 'image_slider')
                ->nullable(),

            // عند Video Slider: فيديو فقط
            FileUpload::make('video')
                ->label('Video (MP4/WebM)')
                ->disk('public')
                ->directory('home/hero/slides')
                ->visibility('public')
                ->preserveFilenames()
                ->acceptedFileTypes(['video/mp4', 'video/webm'])
                ->maxSize(1024 * 50) // 50MB
                ->openable()
                ->downloadable()
                ->visible(fn (Get $get) => $get('../../hero_mode') === 'video_slider')
                ->nullable(),

            // عنوان + وصف للسلايد
            Forms\Components\TextInput::make('title')
                ->label('Titel')
                ->maxLength(255)
                ->nullable(),

            Forms\Components\Textarea::make('subtitle')
                ->label('Undertitel')
                ->rows(2)
                ->nullable(),
        ])
        ->collapsed()
        ->addActionLabel('Lägg till slide')
        ->visible(fn (Get $get) => in_array($get('hero_mode'), ['image_slider', 'video_slider']))
        ->columnSpanFull(),
])->columns(2),

                // ============== INTRO / ABOUT ==============
                Tab::make('About')->schema([
                    Forms\Components\TextInput::make('about_title')->label('Rubrik')->maxLength(255)->nullable(),
                    Forms\Components\ColorPicker::make('intro_accent')->label('Intro Accent')->nullable(),

                    FileUpload::make('about_image')
                        ->label('Intro/Om-bild')
                        ->disk('public')
                        ->directory('home/about')
                        ->visibility('public')
                        ->preserveFilenames()
                        ->image()
                        ->maxSize(4096)
                        ->openable()
                        ->downloadable()
                        ->nullable(),

                    Forms\Components\RichEditor::make('about_body')
                        ->label('Brödtext')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('home/content')
                        ->columnSpanFull()
                        ->nullable(),

                    Forms\Components\TextInput::make('intro_title')->label('Intro titel')->maxLength(255)->nullable(),
                ])->columns(2),

                // ============ GOALS (like Intro) & PILLARS ============
                Tab::make('Mål & Pelare')->schema([
                    Forms\Components\TextInput::make('goals_title')->label('Rubrik mål')->maxLength(255)->nullable(),
                    Forms\Components\ColorPicker::make('goals_accent')->label('Goals Accent')->nullable(),

                    // Goals: now image + title (rubric) + text
                    Repeater::make('goals')
                        ->label('Mål (med bild & rubrik)')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Bild')
                                ->disk('public')
                                ->directory('home/goals')
                                ->visibility('public')
                                ->preserveFilenames()
                                ->image()
                                ->maxSize(4096)
                                ->openable()
                                ->downloadable()
                                ->nullable(),

                           

                            Forms\Components\Textarea::make('text')
                                ->label('Text')
                                ->rows(3)
                                ->nullable(),
                        ])
                        ->collapsed()
                        ->addActionLabel('Lägg till mål')
                        ->columnSpanFull(),

                    // Pillars (keep icon + label; add image if you want symmetry)
                    Repeater::make('pillars')
                        ->label('Pelare (lista)')
                        ->schema([
                            // Uncomment to add image for pillars as well:
                            // FileUpload::make('image')
                            //     ->label('Bild')
                            //     ->disk('public')
                            //     ->directory('home/pillars')
                            //     ->visibility('public')
                            //     ->preserveFilenames()
                            //     ->image()
                            //     ->maxSize(4096)
                            //     ->openable()
                            //     ->downloadable()
                            //     ->nullable(),

                            Forms\Components\TextInput::make('icon')->label('Ikon/Emoji')->nullable(),
                            Forms\Components\TextInput::make('label')->label('Namn')->required(),
                        ])
                        ->collapsed()
                        ->addActionLabel('Lägg till pelare')
                        ->columnSpanFull(),
                ])->columns(2),

                // ================= PRAYER =================
                Tab::make('Bönetider')->schema([
                    Forms\Components\TextInput::make('prayer_title')->label('Rubrik')->maxLength(255)->nullable(),
                    Forms\Components\RichEditor::make('prayer_body')->label('Beskrivning')->nullable()->columnSpanFull(),
                    Forms\Components\TextInput::make('prayer_button_text')->label('Knapptitel')->maxLength(255)->nullable(),
                    Forms\Components\TextInput::make('prayer_button_url')->label('URL')->url()->nullable(),
                ])->columns(2),

                // ================= SERVICES =================
                Tab::make('Tjänster')->schema([
                    Forms\Components\TextInput::make('services_title')->label('Rubrik')->maxLength(255)->nullable(),
                    Forms\Components\RichEditor::make('services_desc')->label('Beskrivning')->nullable()->columnSpanFull(),

                    Repeater::make('services')
                        ->label('Tjänster (kort)')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Bild')
                                ->disk('public')
                                ->directory('home/services')
                                ->visibility('public')
                                ->preserveFilenames()
                                ->image()
                                ->maxSize(4096)
                                ->openable()
                                ->downloadable()
                                ->nullable(),

                            Forms\Components\TextInput::make('title')->label('Titel')->required(),
                            Forms\Components\Textarea::make('text')->label('Text')->rows(2)->nullable(),
                            Forms\Components\TextInput::make('button_text')->label('Knapptitel')->nullable(),
                            Forms\Components\TextInput::make('button_url')->label('URL')->url()->nullable(),
                        ])
                        ->collapsed()
                        ->addActionLabel('Lägg till tjänst')
                        ->columnSpanFull(),
                ])->columns(2),

              // ================= CTA =================
Tab::make('CTA')->schema([
    Forms\Components\TextInput::make('cta_title')
        ->label('Rubrik')
        ->maxLength(255)
        ->nullable(),

    Forms\Components\Textarea::make('cta_subtitle')
        ->label('Undertitel')
        ->rows(3)
        ->nullable(),

    // 🆕 صورة خلفية
    FileUpload::make('cta_background')
        ->label('Bakgrundsbild')
        ->disk('public')
        ->directory('home/cta')
        ->visibility('public')
        ->preserveFilenames()
        ->image()
        ->maxSize(4096)
        ->openable()
        ->downloadable()
        ->nullable(),

    Forms\Components\TextInput::make('cta_button_text')
        ->label('Knapptitel')
        ->maxLength(255)
        ->nullable(),

    Forms\Components\TextInput::make('cta_button_url')
        ->label('URL')
        ->url()
        ->nullable(),
])->columns(2),


                // ================= NEWS =================
                Tab::make('Nyheter')->schema([
                    Forms\Components\Toggle::make('show_latest_news')->label('Visa senaste nytt')->inline(false),
                    Forms\Components\TextInput::make('latest_news_limit')->label('Antal poster')->numeric()->default(4),
                ])->columns(2),
            ])->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        // Table kept simple; index page will redirect to edit in your List page.
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('about_title')->label('Titel')->searchable(),
                Tables\Columns\IconColumn::make('show_latest_news')->boolean()->label('Nyheter'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Uppdaterad'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        // Keep index + edit (singleton behavior handled in ListHomeSettings via redirect)
        return [
            'index' => Pages\ListHomeSettings::route('/'),
            'edit'  => Pages\EditHomeSetting::route('/{record}/edit'),
        ];
    }

    // Disable CRUD beyond editing the single record
    public static function canCreate(): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canReplicate($record): bool { return false; }
    public static function canForceDelete($record): bool { return false; }
}

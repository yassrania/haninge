<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSettingResource\Pages;
use App\Models\HomeSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSettingResource extends Resource
{
    protected static ?string $model = HomeSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Webbplats';
    protected static ?string $navigationLabel = 'Startsida (Home)';
    protected static ?string $modelLabel = 'Startsida';

    public static function form(Form $form): Form
    {
        $urlRule = ['nullable', 'regex:/^(\/|#|https?:\/\/)[^\s]+$/'];

        return $form->schema([
            // ===== HERO / SLIDER =====
            Forms\Components\Section::make('Hero / Slider')->schema([
                Forms\Components\Select::make('hero_mode')
                    ->label('Läge')
                    ->options([
                        'slider' => 'Bild/Video Slider',
                        'single_video' => 'En video',
                        'single_image' => 'En bild',
                    ])
                    ->default('slider'),

                Forms\Components\FileUpload::make('hero_video_file')
                    ->label('Video (uppladdad)')
                    ->directory('home')->disk('public')
                    ->acceptedFileTypes(['video/mp4','video/webm'])
                    ->visible(fn (Get $get) => $get('hero_mode') === 'single_video'),

                Forms\Components\TextInput::make('hero_video_url')
                    ->label('Video URL (YouTube/Vimeo)')
                    ->placeholder('https://youtu.be/... eller /video')
                    ->rules($urlRule)
                    ->extraInputAttributes(['inputmode' => 'text'])
                    ->visible(fn (Get $get) => $get('hero_mode') === 'single_video'),

                Forms\Components\FileUpload::make('hero_image')
                    ->label('Hero-bild')
                    ->directory('home')->disk('public')
                    ->image()
                    ->visible(fn (Get $get) => $get('hero_mode') === 'single_image'),

                Forms\Components\Repeater::make('slides')
                    ->label('Slides')
                    ->visible(fn (Get $get) => $get('hero_mode') === 'slider')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Typ')
                            ->options([
                                'image' => 'Bild',
                                'video_file' => 'Video (uppladdad)',
                                'video_url' => 'Video URL',
                            ])
                            ->default('image'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Bild')
                            ->directory('home/slides')->disk('public')
                            ->image()
                            ->visible(fn (Get $get) => $get('type') === 'image'),

                        Forms\Components\FileUpload::make('video_file')
                            ->label('Video (mp4/webm)')
                            ->directory('home/slides')->disk('public')
                            ->acceptedFileTypes(['video/mp4','video/webm'])
                            ->visible(fn (Get $get) => $get('type') === 'video_file'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL (YouTube/Vimeo)')
                            ->placeholder('https://vimeo.com/... eller /video')
                            ->rules($urlRule)
                            ->extraInputAttributes(['inputmode' => 'text'])
                            ->visible(fn (Get $get) => $get('type') === 'video_url'),

                        Forms\Components\TextInput::make('caption')->label('Text'),
                        Forms\Components\TextInput::make('button_text')->label('Knapptext'),
                        Forms\Components\TextInput::make('button_url')
                            ->label('Knapp-URL')
                            ->placeholder('/om-oss eller https://exempel.se')
                            ->rules($urlRule)
                            ->extraInputAttributes(['inputmode' => 'text']),
                    ])
                    ->columns(2),
            ])->columns(2),

            // ===== INTRO =====
            Forms\Components\Section::make('Intro')->schema([
                Forms\Components\TextInput::make('intro_title')
                    ->label('Titel (Intro, ex: Alby moské)')
                    ->maxLength(120),
                Forms\Components\TextInput::make('intro_accent')
                    ->label('Accent line (ex: En moské i hjärtat av Botkyrka)')
                    ->maxLength(160),
                Forms\Components\FileUpload::make('about_image')
                    ->label('Bild (Intro)')
                    ->directory('home')->disk('public')
                    ->image(),
                Forms\Components\RichEditor::make('about_body')
                    ->label('Beskrivning (Intro)')
                    ->toolbarButtons(['bold','italic','strike','underline','h2','h3','bulletList','orderedList','link'])
                    ->columnSpanFull(),
            ])->columns(2),

            // ===== VÅRA MÅL =====
           Forms\Components\Section::make('Våra mål')->schema([
    Forms\Components\TextInput::make('goals_title')->label('Titel (Goals)')->maxLength(120),
    Forms\Components\TextInput::make('goals_accent')->label('Accent line (Goals)')->maxLength(160),

    Forms\Components\Repeater::make('goals')
        ->label('Mål')
        ->schema([
            Forms\Components\FileUpload::make('image')
                ->label('Bild')->directory('home/goals')->disk('public')->image(),

            Forms\Components\TextInput::make('title')
                ->label('Titel')->maxLength(160),

            Forms\Components\Textarea::make('body')
                ->label('Beskrivning')
                ->rows(8)
                ->columnSpanFull(), // ← كبير وعلى عرض الكارد
        ])
        ->columns(2),
            ]),

            // ===== ISLAMS PELARE =====
            Forms\Components\Section::make('Islams pelare')->schema([
                Forms\Components\Repeater::make('pillars')
                    ->label('Pelare')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Titel'),
                        Forms\Components\TextInput::make('icon')->label('Ikon klass (t.ex. heroicon...)'),
                        Forms\Components\Textarea::make('body')->label('Beskrivning')->rows(2),
                    ])
                    ->columns(2),
            ]),

            // ===== PRAYER BLOCK =====
            Forms\Components\Section::make('Bön-block')->schema([
                Forms\Components\TextInput::make('prayer_title')->label('Titel'),
                Forms\Components\Textarea::make('prayer_body')->label('Text')->rows(2),
                Forms\Components\TextInput::make('prayer_button_text')->label('Knapptext'),
                Forms\Components\TextInput::make('prayer_button_url')
                    ->label('Knapp-URL')
                    ->rules($urlRule)
                    ->extraInputAttributes(['inputmode' => 'text']),
            ])->columns(2),

            // ===== TJÄNSTER =====
            Forms\Components\Section::make('Tjänster')->schema([
                Forms\Components\TextInput::make('services_title')->label('Sektionstitel'),
                Forms\Components\Textarea::make('services_desc')->label('Beskrivning')->rows(2),
                Forms\Components\Repeater::make('services')
                    ->label('Tjänster')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Bild')
                            ->directory('home/services')->disk('public')
                            ->image(),
                        Forms\Components\TextInput::make('title')->label('Titel'),
                        Forms\Components\Textarea::make('body')->label('Beskrivning')->rows(2),
                        Forms\Components\TextInput::make('button_text')->label('Knapptext'),
                        Forms\Components\TextInput::make('button_url')
                            ->label('URL')
                            ->rules($urlRule)
                            ->extraInputAttributes(['inputmode' => 'text']),
                    ])
                    ->columns(2),
            ]),

            // ===== CTA =====
            Forms\Components\Section::make('CTA')->schema([
                Forms\Components\TextInput::make('cta_title')->label('Titel'),
                Forms\Components\TextInput::make('cta_subtitle')->label('Undertitel'),
                Forms\Components\TextInput::make('cta_button_text')->label('Knapptext'),
                Forms\Components\TextInput::make('cta_button_url')
                    ->label('Knapp-URL')
                    ->rules($urlRule)
                    ->extraInputAttributes(['inputmode' => 'text']),
            ])->columns(2),

            // ===== LATEST NEWS =====
            Forms\Components\Section::make('Senaste nytt')->schema([
                Forms\Components\Toggle::make('show_latest_news')->label('Visa senaste nytt?')->default(true),
                Forms\Components\TextInput::make('latest_news_limit')->label('Antal')->numeric()->default(6),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('updated_at')->label('Uppdaterad')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHomeSettings::route('/'),
        ];
    }
}

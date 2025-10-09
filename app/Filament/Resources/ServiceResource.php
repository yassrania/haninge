<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Builder;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon   = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel  = 'Tjänster';
    protected static ?string $pluralModelLabel = 'Tjänster';
    protected static ?string $modelLabel       = 'Tjänst';
    protected static ?string $navigationGroup  = 'Sajtinställningar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tjänst')->tabs([

                // ============ Allmänt ============
                Tab::make('Allmänt')->schema([
                    TextInput::make('title')
                        ->label('Titel')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Toggle::make('published')
                        ->label('Publicerad')
                        ->default(true),

                    FileUpload::make('page_banner')
                        ->label('Banner (överst)')
                        ->disk('public')
                        ->directory('services/banners')
                        ->visibility('public')
                        ->image()
                        ->maxSize(8192)
                        ->openable()
                        ->downloadable()
                        ->nullable(),

                    TextInput::make('subtitle')
                        ->label('Undertitel')
                        ->maxLength(255)
                        ->nullable(),
                      

// داخل schema تبويب Allmänt (أو المكان اللي يناسبك):
Select::make('inbox_target')
    ->label('Skicka till inkorg')
    ->options([
        'vigsel'   => 'Vigselförfrågningar',
        'vuxen'    => 'Vuxenstudier',
        'barn'     => 'Barnstudier',
        'kontakt'  => 'Kontaktmeddelanden',
    ])
    ->helperText('Välj vilken inkorg som ska ta emot formuläret.')
    ->nullable(),

                ])->columns(2),

                // ============ Innehåll (Builder) ============
                Tab::make('Innehåll')->schema([
                    Builder::make('blocks')
                        ->label('Innehållsblock')
                        ->blocks([
                            // عنوان قسم
                            Builder\Block::make('section_title')
                                ->label('Rubrik (sektion)')
                                ->schema([
                                    TextInput::make('title')->label('Rubrik (H2)')->required(),
                                    TextInput::make('subtitle')->label('Underrubrik (H6)')->nullable(),
                                ]),

                            // نص غني
                            Builder\Block::make('rich_text')
                                ->label('Rich text')
                                ->schema([
                                    RichEditor::make('content')
                                        ->label('Text')
                                        ->fileAttachmentsDisk('public')
                                        ->fileAttachmentsDirectory('services/content')
                                        ->columnSpanFull(),
                                ]),

                            // صورة + نص (نفس مفاتيح show.blade)
                            Builder\Block::make('image_with_text')
                                ->label('Bild + Text')
                                ->schema([
                                    FileUpload::make('image')
                                        ->label('Bild')
                                        ->disk('public')
                                        ->directory('services/blocks')
                                        ->visibility('public')
                                        ->image()
                                        ->maxSize(8192)
                                        ->openable()
                                        ->downloadable()
                                        ->required(),

                                    TextInput::make('title')->label('Rubrik')->nullable(),
                                    Textarea::make('text')->label('Text')->rows(5)->nullable(),

                                   Select::make('image_position')
    ->label('Bildposition')
    ->options([
        'left'  => 'Vänster',
        'right' => 'Höger',
    ])
    ->default('left')
    ->required(),
                                ])->columns(2),
                        ])
                        ->collapsed(),
                ])->columns(1),

               // ============ Formulär ============
Tab::make('Formulär')->schema([

    TextInput::make('form_title')
        ->label('Formulärtitel')
        ->placeholder('Ansök om vigsel i enlighet med Islam')
        ->nullable(),

    Forms\Components\Repeater::make('form_fields')
        ->label('Formulärfält')
        ->schema([

            // المجموعة / الخطوة (لعرض النموذج كـ wizard)
            TextInput::make('group')
                ->label('Steg / Grupp')
                ->placeholder('MAKE / MAKA / DATUM')
                ->required(),

            // ترتيب داخل الخطوة
            TextInput::make('order')
                ->numeric()
                ->label('Ordning')
                ->default(0),

            // نوع الحقل
            Select::make('type')
                ->label('Typ')
                ->options([
                    'text'        => 'Text',
                    'email'       => 'Email',
                    'tel'         => 'Telefon',
                    'textarea'    => 'Textområde',
                    'select'      => 'Välj',
                    'checkbox'    => 'Checkbox',
                    'file'        => 'Fil',
                    'date'        => 'Datum',
                    'time'        => 'Tid',
                    'description' => 'Beskrivande text', // النص الوصفي (بدون input)
                ])
                ->required(),

            // اسم الحقل (غير مطلوب إذا النوع وصف "description")
            TextInput::make('name')
                ->label('Name (slug)')
                ->helperText('t.ex. groom_first_name, bride_email, ceremony_date')
                ->required(fn (callable $get) => $get('type') !== 'description')
                ->visible(fn (callable $get) => $get('type') !== 'description'),

            // التسمية (label) — ليست ضرورية للوصف أو للـ checkbox
            TextInput::make('label')
                ->label('Etikett')
                ->required(fn (callable $get) => !in_array($get('type'), ['description', 'checkbox']))
                ->visible(fn (callable $get) => $get('type') !== 'description'),

            TextInput::make('placeholder')
                ->label('Placeholder')
                ->nullable()
                ->visible(fn (callable $get) => !in_array($get('type'), ['description', 'checkbox', 'select'])),

            TextInput::make('help')
                ->label('Hjälptext')
                ->nullable()
                ->visible(fn (callable $get) => $get('type') !== 'description'),

            // خيارات للقائمة (select) فقط
            TextInput::make('options')
                ->label('Alternativ (för select)')
                ->helperText('comma,separated')
                ->nullable()
                ->visible(fn (callable $get) => $get('type') === 'select'),

            // الوصف النصي (RichEditor) — يظهر فقط لنوع description
            RichEditor::make('content')
                ->label('Beskrivande text')
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('services/forms/content')
                ->visible(fn (callable $get) => $get('type') === 'description')
                ->columnSpanFull(),

            // مطلوب؟ (لا معنى لها للوصف)
            Select::make('required')
                ->label('Obligatorisk?')
                ->options(['0' => 'Nej', '1' => 'Ja'])
                ->default('0')
                ->visible(fn (callable $get) => $get('type') !== 'description'),

            // عرض الحقل (شبكة مرنة) — ليس للوصف (الوصف يأخذ عرض كامل)
            Select::make('width')
                ->label('Bredd')
                ->options([
                    '1'   => '100%',
                    '1/2' => '50%',
                    '1/3' => '33%',
                ])
                ->default('1/3')
                ->visible(fn (callable $get) => $get('type') !== 'description'),

        ])
        ->columns(3)
        ->orderable('order')    // السحب لترتيب الحقول داخل المجموعة
        ->collapsed()
        ->addActionLabel('Lägg till fält'),

])->columns(2),


                // ============ Donera ============
                Tab::make('Donera')->schema([
                    FileUpload::make('donate_qr_image')
                        ->label('QR-bild')
                        ->disk('public')
                        ->directory('services/donate')
                        ->visibility('public')
                        ->image()
                        ->maxSize(8192)
                        ->openable()
                        ->downloadable()
                        ->nullable(),

                    TextInput::make('donate_title')->label('Rubrik')->maxLength(255)->nullable(),
                    TextInput::make('donate_subtitle')->label('Underrubrik')->maxLength(255)->nullable(),

                    RichEditor::make('donate_article')
                        ->label('Artikel / text')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('services/donate/content')
                        ->columnSpanFull()
                        ->nullable(),

                    TextInput::make('donate_btn_text')->label('Knapptitel')->maxLength(255)->nullable(),
                    TextInput::make('donate_btn_url')->label('URL')->url()->nullable(),
                ])->columns(2),

            ])->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titel')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('published')->boolean()->label('Publicerad'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Uppdaterad'),
            ])
            ->filters([])
            ->actions([ Tables\Actions\EditAction::make() ])
            ->bulkActions([]);
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

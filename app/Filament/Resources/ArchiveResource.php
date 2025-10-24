<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArchiveResource\Pages;
use App\Models\Archive;
use Filament\Forms;

use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class ArchiveResource extends Resource
{
    protected static ?string $model = Archive::class;
     protected static ?string $navigationLabel = 'Arkiv';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
   
    // نتركها بدون group حتى لا تكون داخل Sajtinställningar
protected static ?string $navigationGroup = null;

// نضيف ترتيبها لتظهر مباشرة تحت Sajtinställningar
protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Titel')->required()->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

            Forms\Components\TextInput::make('slug')
                ->label('Slug')->required()->unique(ignoreRecord: true),

            Forms\Components\DatePicker::make('event_date')->label('Datum')->native(false),

            Forms\Components\FileUpload::make('images')
                ->label('Bilder')
                ->directory('archives')  // storage/app/public/archives
                ->multiple()
                ->image()
                ->reorderable()
                ->downloadable()
                ->openable()
                ->maxFiles(50)
                ->maxSize(8192)
                ->helperText('Ladda upp en eller flera bilder.'),

            Forms\Components\Textarea::make('excerpt')->label('Sammanfattning')->rows(3),

            Forms\Components\RichEditor::make('body')
                ->label('Innehåll')
                ->toolbarButtons([
                    'bold','italic','underline','strike','blockquote','link',
                    'orderedList','unorderedList','h2','h3','codeBlock',
                ])->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')->label('Aktiv')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.0')->label('Bild')->square(), // أول صورة
                Tables\Columns\TextColumn::make('title')->label('Titel')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('event_date')->label('Datum')->date()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktiv')->boolean(),
            ])
            ->defaultSort('event_date', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArchives::route('/'),
            'create' => Pages\CreateArchive::route('/create'),
            'edit'   => Pages\EditArchive::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NyhetResource\Pages;
use App\Models\Nyhet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, FileUpload, RichEditor, Toggle, DateTimePicker, Section, Grid};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Actions\{CreateAction, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};
use Illuminate\Support\Str;

class NyhetResource extends Resource
{
    protected static ?string $model = Nyhet::class;

    protected static ?string $navigationIcon  = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationLabel = 'Nyheter';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Nyhet')->columns(2)->schema([
                TextInput::make('title')->label('Titel')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if (blank($get('slug'))) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),

                TextInput::make('excerpt')->label('Kort text')->maxLength(300)->columnSpanFull(),

                RichEditor::make('body')->label('Stor text')->columnSpanFull()
                    ->toolbarButtons([
                        'bold','italic','underline','strike',
                        'h2','h3','blockquote','orderedList','bulletList',
                        'link','undo','redo',
                    ]),

                FileUpload::make('image_path')->label('Bild')->image()
                    ->directory('nyheter/images')->preserveFilenames(),

                Grid::make(2)->schema([
                    Toggle::make('published')->label('Publicerad')->default(true),
                    DateTimePicker::make('published_at')->label('Publicerad datum')
                        ->seconds(false)->native(false)->default(now()),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titel')->searchable()->limit(40),
                TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('published')->label('Publicerad')->boolean(),
                TextColumn::make('published_at')->label('Datum')->dateTime('Y-m-d H:i')->sortable(),
                TextColumn::make('updated_at')->label('Uppdaterad')->since(),
            ])
            ->actions([ EditAction::make(), DeleteAction::make() ])
            ->headerActions([ CreateAction::make()->label('Add') ])
            ->bulkActions([ BulkActionGroup::make([ DeleteBulkAction::make() ]) ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNyheter::route('/'),
        ];
    }
}

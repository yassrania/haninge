<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TjansterPageResource\Pages;
use App\Models\TjansterPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TjansterPageResource extends Resource
{
    protected static ?string $model = TjansterPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Tjänster';
    protected static ?string $pluralModelLabel = 'Tjänster';
    protected static ?string $modelLabel = 'Tjänst';
    protected static ?string $navigationGroup = 'Innehåll';

    public static function getSlug(): string
    {
        return 'tjanster-pages'; // مهم باش يطابق اسم الراوت اللي طالع فالخطأ
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Titel')->required(),
            Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Toggle::make('is_active')->label('Aktiv')->default(true),
            Forms\Components\Textarea::make('content')->label('Innehåll')->rows(6),
            Forms\Components\TextInput::make('sort_order')->label('Sortering')->numeric()->default(0),
            Forms\Components\DateTimePicker::make('published_at')->label('Publicerad'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titel')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktiv')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Sortering')->sortable(),
                Tables\Columns\TextColumn::make('published_at')->label('Publicerad')->dateTime()->since(),
                Tables\Columns\TextColumn::make('created_at')->label('Skapad')->dateTime()->since(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('Redigera'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Radera'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTjansterPages::route('/'),
            'create' => Pages\CreateTjansterPage::route('/create'),
            'edit'   => Pages\EditTjansterPage::route('/{record}/edit'),
        ];
    }
}

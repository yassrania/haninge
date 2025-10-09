<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OmMoskenDonateResource\Pages;
use App\Models\OmMoskenDonate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Toggle, FileUpload, RichEditor, Section, Grid};
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Cache;

class OmMoskenDonateResource extends Resource
{
    protected static ?string $model = OmMoskenDonate::class;

    protected static ?string $navigationIcon  = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Sajtinställningar';
    protected static ?string $navigationLabel = 'Om Mosken – Stöd';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Donera/Stöd')->columns(2)->schema([
                Toggle::make('enabled')->label('Aktivera Stöd-sektionen')->inline(false),
                FileUpload::make('qr_path')->label('QR/Swish Bild')->image()->directory('om-mosken/qr')->preserveFilenames(),

                TextInput::make('title')->label('Title')->maxLength(150),
                TextInput::make('subtitle')->label('Undertitle')->maxLength(200),

                RichEditor::make('body')->label('Text')->toolbarButtons([
                    'bold','italic','underline','strike',
                    'h2','h3','blockquote','orderedList','bulletList',
                    'link','undo','redo',
                ])->columnSpanFull(),

                Grid::make(2)->schema([
                    TextInput::make('button_label')->label('Button Text')->maxLength(50),
                    TextInput::make('button_url')->label('Button URL')->url()->maxLength(255),
                ]),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [ 'index' => Pages\EditOmMoskenDonate::route('/') ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    // امسح كاش الواجهة
    public static function afterSave(): void { Cache::forget('om_mosken_donate'); }
}

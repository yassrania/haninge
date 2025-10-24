<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipApplicationResource\Pages;
use App\Models\MembershipApplication;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\HtmlString;

class MembershipApplicationResource extends Resource
{
    protected static ?string $model = MembershipApplication::class;

    protected static ?string $navigationIcon   = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup  = 'Formulär';
    protected static ?string $modelLabel       = 'Membership Application';
    protected static ?string $pluralModelLabel = 'Membership Applications';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('full_name')->label('Full name')->disabled(),
            Forms\Components\TextInput::make('email')->label('Email')->disabled(),
            Forms\Components\TextInput::make('phone')->label('Phone')->disabled(),
            Forms\Components\TextInput::make('address')->label('Address')->disabled(),
            Forms\Components\Textarea::make('notes')->label('Notes')->rows(6)->disabled(),

            // ⇩⇩ لا تستخدم contentHtml() في v3 ⇩⇩
            Forms\Components\Placeholder::make('signature_preview')
                ->label('Signatur')
                ->content(fn ($record) => new HtmlString(
                    $record?->signature_path
                        ? '<img src="'.asset('storage/'.$record->signature_path).'" style="max-height:120px">'
                        : '<em>Ingen</em>'
                )),
        ])->disabled(); // عرض فقط
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Id')->sortable(),
                Tables\Columns\TextColumn::make('full_name')->label('Full name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Phone')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')->label('Address')->limit(30)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->label('Created at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->actions([
             // أو خيار 2: باستخدام اسم الراوت (مفضل إذا الاسم مضبوط)
Tables\Actions\Action::make('pdf')
    ->label('Visa PDF')
    ->url(fn ($record) => route('admin.membership.pdf', ['id' => $record->getKey()]))
    ->openUrlInNewTab(),


                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembershipApplications::route('/'),
            'view'  => Pages\ViewMembershipApplication::route('/{record}'),
        ];
    }
}

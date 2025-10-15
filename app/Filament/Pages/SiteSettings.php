<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class SiteSettings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Inställningar';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Webbplatsinställningar';

    protected static string $view = 'filament.pages.site-settings';

    /** Form state */
    public ?array $data = [];

    /** The settings record */
    public Setting $record;

    public function mount(): void
    {
        // إنشاء سجل واحد إذا لم يوجد
        $this->record = Setting::firstOrCreate([]);
        // تعبئة الفورم
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')->label('Sidnamn')->required(),
                FileUpload::make('logo')
                    ->label('Logotyp')
                    ->disk('public')
                    ->directory('settings')
                    ->image()
                    ->maxSize(4096) // 4MB
                    ->acceptedFileTypes(['image/png','image/jpeg','image/webp','image/svg+xml'])
                    ->openable()
                    ->downloadable()
                    ->deletable(true),
                TextInput::make('email')->label('E-post'),
                TextInput::make('phone')->label('Telefon'),
                TextInput::make('address')->label('Adress'),
                KeyValue::make('social')->label('Sociala länkar')->keyLabel('Nätverk')->valueLabel('URL'),
            ])
            ->statePath('data');
    }

public function getHeaderActions(): array
{
    return [
        Actions\Action::make('clearLogo')
            ->label('Rensa logotyp')
            ->color('danger')
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->visible(fn () => filled($this->record->logo))
            ->action(function () {
                if ($this->record->logo) {
                    Storage::disk('public')->delete($this->record->logo);
                    $this->record->logo = null;
                    $this->record->save();
                    $this->form->fill($this->record->toArray());

                    // امسح كاش الإعدادات
                    cache()->forget('site_settings');
                }

                Notification::make()
                    ->title('Logotyp raderades.')
                    ->success()
                    ->send();
            }),
    ];
}

public function save(): void
{
    $this->record->update($this->form->getState());

    // امسح كاش الإعدادات عشان تنعكس مباشرة
    cache()->forget('site_settings');

    Notification::make()
        ->title('Inställningarna har sparats.')
        ->success()
        ->send();

        }
         }


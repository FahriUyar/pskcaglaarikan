<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GeneralSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Ayarlar';

    protected static ?string $navigationLabel = 'Genel Ayarlar';

    protected static ?string $title = 'Genel Ayarlar';

    protected static ?int $navigationSort = 99;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_title' => Setting::get('site_title'),
            'site_description' => Setting::get('site_description'),
            'phone' => Setting::get('phone'),
            'whatsapp' => Setting::get('whatsapp'),
            'email' => Setting::get('email'),
            'address' => Setting::get('address'),
            'instagram' => Setting::get('instagram'),
            'map_embed' => Setting::get('map_embed'),
            'logo' => Setting::get('logo'),
            'favicon' => Setting::get('favicon'),
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->operation('edit')
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Site Bilgileri'))
                    ->schema([
                        TextInput::make('site_title')
                            ->label('Site Başlığı')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('site_description')
                            ->label('Site Açıklaması')
                            ->rows(2)
                            ->maxLength(500),
                    ]),

                Section::make(__('İletişim Bilgileri'))
                    ->schema([
                        TextInput::make('phone')
                            ->label('Telefon Numarası')
                            ->tel()
                            ->placeholder('0(5XX) XXX XX XX'),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp Linki')
                            ->url()
                            ->placeholder('https://wa.me/905XXXXXXXXX')
                            ->helperText('WhatsApp uygulamasını açacak veya doğrudan sohbete yönlendirecek tam linki girin (örn: https://wa.me/905077084043?text=Merhaba).'),
                        TextInput::make('email')
                            ->label('E-posta Adresi')
                            ->email()
                            ->placeholder('ornek@email.com'),
                        Textarea::make('address')
                            ->label('Adres')
                            ->rows(2),
                    ]),

                Section::make(__('Sosyal Medya'))
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram Profil URL')
                            ->url()
                            ->placeholder('https://instagram.com/kullaniciadi'),
                    ]),

                Section::make(__('Harita'))
                    ->schema([
                        Textarea::make('map_embed')
                            ->label('Google Maps Gömme Kodu')
                            ->rows(4)
                            ->helperText('Google Maps\'ten "Paylaş → Haritayı Göm" seçeneği ile aldığınız iframe kodunu buraya yapıştırın.'),
                    ]),

                Section::make(__('Logo ve Favicon'))
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Site Logosu')
                            ->image()
                            ->directory('settings')
                            ->imageEditor()
                            ->maxSize(1024),
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('settings')
                            ->maxSize(2048)
                            ->helperText('32×32 veya 64×64 boyutunda bir ikon yükleyin.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $groupMap = [
            'site_title' => 'general',
            'site_description' => 'general',
            'phone' => 'contact',
            'whatsapp' => 'contact',
            'email' => 'contact',
            'address' => 'contact',
            'instagram' => 'social',
            'map_embed' => 'contact',
            'logo' => 'general',
            'favicon' => 'general',
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $groupMap[$key] ?? 'general');
        }

        Notification::make()
            ->title('Ayarlar başarıyla kaydedildi.')
            ->success()
            ->send();
    }

    /**
     * @return array<Action|ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Kaydet')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions())
                    ->alignment($this->getFormActionsAlignment())
                    ->sticky($this->areFormActionsSticky()),
            ]);
    }
}

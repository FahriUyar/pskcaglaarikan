<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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

class ContactPageContent extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static string|\UnitEnum|null $navigationGroup = 'Sayfalar';

    protected static ?string $navigationLabel = 'İletişim Sayfası';

    protected static ?string $title = 'İletişim Sayfası Ayarları';

    protected static ?int $navigationSort = 4;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'contact_page_title' => Setting::get('contact_page_title'),
            'contact_page_description' => Setting::get('contact_page_description'),
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
                Section::make(__('İletişim Sayfası İçeriği'))
                    ->description('İletişim sayfasının hero bölümünde görünen başlık ve açıklama metni.')
                    ->schema([
                        TextInput::make('contact_page_title')
                            ->label('Sayfa Başlığı')
                            ->placeholder('İletişime Geçin')
                            ->maxLength(255),
                        Textarea::make('contact_page_description')
                            ->label('Açıklama Metni')
                            ->rows(3)
                            ->helperText('İletişim sayfasının üst kısmında, başlığın altında görünen açıklama.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'contact');
        }

        Notification::make()
            ->title('İletişim sayfası güncellendi.')
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

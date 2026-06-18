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

class HomePageContent extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static string|\UnitEnum|null $navigationGroup = 'Sayfalar';

    protected static ?string $navigationLabel = 'Ana Sayfa';

    protected static ?string $title = 'Ana Sayfa Ayarları';

    protected static ?int $navigationSort = 0;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'home_hero_title' => Setting::get('home_hero_title', 'Hayatınıza Yeni Bir <br> <span class="text-primary">Pencere Açın</span>'),
            'home_hero_text' => Setting::get('home_hero_text', 'Zorlukların üstesinden gelirken yanınızdayız. Bilimsel yöntemler ve şefkatli bir yaklaşımla, kendi içinizdeki gücü keşfetmenize yardımcı oluyoruz.'),
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
                Section::make(__('Karşılama Ekranı (Hero)'))
                    ->description('Ana sayfanın en üstünde yer alan ana başlık ve açıklama.')
                    ->schema([
                        TextInput::make('home_hero_title')
                            ->label('Ana Başlık')
                            ->helperText('HTML etiketleri kullanabilirsiniz (örn: <br> veya renklendirme için <span class="text-primary">...</span>).')
                            ->required(),
                        Textarea::make('home_hero_text')
                            ->label('Açıklama Metni')
                            ->rows(3)
                            ->required(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'home');
        }

        Notification::make()
            ->title('Ana sayfa güncellendi.')
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

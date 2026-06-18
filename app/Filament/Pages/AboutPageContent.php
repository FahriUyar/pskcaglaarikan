<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutPageContent extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected static string|\UnitEnum|null $navigationGroup = 'Sayfalar';

    protected static ?string $navigationLabel = 'Hakkımda';

    protected static ?string $title = 'Hakkımda Sayfası';

    protected static ?int $navigationSort = 1;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'about_image' => Setting::get('about_image'),
            'about_hero_description' => Setting::get('about_hero_description'),
            'about_text' => Setting::get('about_text'),
            'about_approach_title' => Setting::get('about_approach_title'),
            'about_approach_text' => Setting::get('about_approach_text'),
            'about_values' => Setting::get('about_values'),
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
                Grid::make(3)
                    ->schema([
                        Section::make(__('Hakkımda İçeriği'))
                            ->description('Ana sayfada ve hakkımda sayfasında görünen metin.')
                            ->columnSpan(2)
                            ->schema([
                                Textarea::make('about_hero_description')
                                    ->label('Kısa Tanıtım Metni (Hero)')
                                    ->rows(3)
                                    ->helperText('İsminizin hemen altında görünecek, sizi kısaca tanıtan bir metin.'),
                                RichEditor::make('about_text')
                                    ->label('Hakkımda Metni')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('settings/attachments')
                                    ->helperText('Bu metin hakkımda sayfasının ana içerik alanında görünecektir.'),
                            ]),

                        Section::make(__('Fotoğraf'))
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('about_image')
                                    ->label('Profil Fotoğrafı')
                                    ->image()
                                    ->directory('settings')
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('Ana sayfa hero ve hakkımda sayfasında kullanılacak fotoğraf.'),
                            ]),
                    ]),

                Section::make(__('Terapötik Yaklaşım (Sidebar Kartı)'))
                    ->description('Hakkımda sayfasının sağ tarafında görünen kart.')
                    ->schema([
                        TextInput::make('about_approach_title')
                            ->label('Kart Başlığı')
                            ->placeholder('Terapötik Yaklaşım')
                            ->maxLength(255),
                        Textarea::make('about_approach_text')
                            ->label('Kart Açıklaması')
                            ->rows(3),
                    ]),

                Section::make(__('Değerlerim (Sidebar Kartı)'))
                    ->description('Hakkımda sayfasının sağ tarafında görünen değerler listesi. JSON formatında bir dizi girin.')
                    ->schema([
                        Textarea::make('about_values')
                            ->label('Değerler Listesi')
                            ->rows(4)
                            ->helperText('JSON formatında yazın, örn: ["Kişiye özgü terapi çerçevesi","Danışanın temposuna saygı"]'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $groupMap = [
            'about_image' => 'about',
            'about_hero_description' => 'about',
            'about_text' => 'about',
            'about_approach_title' => 'about',
            'about_approach_text' => 'about',
            'about_values' => 'about',
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $groupMap[$key] ?? 'about');
        }

        Notification::make()
            ->title('Hakkımda sayfası güncellendi.')
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

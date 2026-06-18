<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpan('full')
                    ->schema([
                        // Sol taraf — Ana içerik (2/3)
                        Section::make('Yazı İçeriği')
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Textarea::make('excerpt')
                                    ->label('Kısa Özet')
                                    ->rows(3)
                                    ->helperText('Listeleme sayfasında ve SEO açıklamasında gösterilir.'),
                                RichEditor::make('body')
                                    ->label('İçerik')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('posts/attachments'),
                            ]),

                        // Sağ taraf — Ayarlar (1/3)
                        Section::make('Yayın Ayarları')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->placeholder('Kategori seçin'),
                                Select::make('status')
                                    ->label('Durum')
                                    ->options([
                                        'draft' => 'Taslak',
                                        'published' => 'Yayında',
                                        'archived' => 'Arşivlenmiş',
                                    ])
                                    ->default('draft')
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('Yayın Tarihi')
                                    ->default(now())
                                    ->displayFormat('d.m.Y H:i')
                                    ->native(false),
                                FileUpload::make('cover_image')
                                    ->label('Kapak Görseli')
                                    ->image()
                                    ->directory('posts/covers')
                                    ->imageEditor()
                                    ->maxSize(2048),
                            ]),

                        // SEO bölümü — tam genişlik
                        Section::make('SEO Ayarları')
                            ->columnSpanFull()
                            ->collapsed()
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('SEO Başlık')
                                    ->maxLength(255)
                                    ->helperText('Boş bırakılırsa yazı başlığı kullanılır.'),
                                Textarea::make('meta_description')
                                    ->label('SEO Açıklama')
                                    ->rows(2)
                                    ->maxLength(255)
                                    ->helperText('Boş bırakılırsa kısa özet kullanılır.'),
                            ]),
                    ]),
            ]);
    }
}

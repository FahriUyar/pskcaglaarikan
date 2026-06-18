<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hizmet Bilgileri ve İçerik')
                    ->columnSpan('full')
                    ->schema([
                        TextInput::make('title')
                            ->label('Hizmet Başlığı')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('URL (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->label('Kısa Açıklama')
                            ->rows(3)
                            ->helperText('Kart görünümünde gösterilecek kısa metin.'),
                        FileUpload::make('cover_image')
                            ->label('Kapak Görseli')
                            ->image()
                            ->directory('services/covers')
                            ->imageEditor()
                            ->maxSize(2048),
                        RichEditor::make('body')
                            ->label('Detaylı İçerik')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('services/attachments'),
                        TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }
}

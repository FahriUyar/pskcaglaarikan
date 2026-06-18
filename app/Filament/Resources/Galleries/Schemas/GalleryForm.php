<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Başlık')
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label('Görsel')
                    ->image()
                    ->required()
                    ->directory('gallery')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull(),
                TextInput::make('alt_text')
                    ->label('Alt Metin (Erişilebilirlik)')
                    ->maxLength(255)
                    ->helperText('Görselin ekran okuyucular için açıklaması.'),
                TextInput::make('sort_order')
                    ->label('Sıralama')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}

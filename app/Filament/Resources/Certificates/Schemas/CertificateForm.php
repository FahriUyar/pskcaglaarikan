<?php

namespace App\Filament\Resources\Certificates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Sertifika Adı')
                    ->required()
                    ->maxLength(255),
                TextInput::make('institution')
                    ->label('Veren Kurum')
                    ->maxLength(255),
                DatePicker::make('date')
                    ->label('Alınma Tarihi')
                    ->displayFormat('d.m.Y')
                    ->native(false),
                FileUpload::make('image')
                    ->label('Sertifika Dosyası (Görsel veya PDF)')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->required()
                    ->directory('certificates')
                    ->maxSize(5120)
                    ->columnSpanFull(),
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

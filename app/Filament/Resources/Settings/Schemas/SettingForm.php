<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    /**
     * Dosya yükleme gerektiren key'ler.
     */
    private const FILE_KEYS = [
        'about_image',
        'logo',
        'favicon',
    ];

    /**
     * Zengin metin editörü gerektiren key'ler.
     */
    private const RICHTEXT_KEYS = [
        'about_text',
    ];

    /**
     * Uzun metin alanı gerektiren key'ler.
     */
    private const TEXTAREA_KEYS = [
        'map_embed',
        'about_values',
        'about_approach_text',
        'contact_page_description',
        'site_description',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Anahtar')
                    ->disabled()
                    ->required(),
                TextInput::make('group')
                    ->label('Grup')
                    ->disabled()
                    ->required(),

                // Dosya yükleme alanı — sadece ilgili key'lerde gösterilir
                FileUpload::make('value')
                    ->label('Değer (Dosya)')
                    ->directory('settings')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record && in_array($record->key, self::FILE_KEYS)),

                // Zengin metin editörü — sadece ilgili key'lerde gösterilir
                RichEditor::make('value')
                    ->label('Değer')
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('settings/attachments')
                    ->visible(fn ($record) => $record && in_array($record->key, self::RICHTEXT_KEYS)),

                // Uzun metin alanı — sadece ilgili key'lerde gösterilir
                Textarea::make('value')
                    ->label('Değer')
                    ->rows(4)
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record && in_array($record->key, self::TEXTAREA_KEYS)),

                // Varsayılan kısa metin — diğer tüm key'ler
                TextInput::make('value')
                    ->label('Değer')
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record && !in_array($record->key, [
                        ...self::FILE_KEYS,
                        ...self::RICHTEXT_KEYS,
                        ...self::TEXTAREA_KEYS,
                    ])),
            ]);
    }
}

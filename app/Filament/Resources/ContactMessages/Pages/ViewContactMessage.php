<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if (! $this->record->is_read) {
            $this->record->markAsRead();
        }
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Gönderen Bilgileri')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Ad Soyad'),
                        TextEntry::make('email')
                            ->label('E-posta'),
                        TextEntry::make('phone')
                            ->label('Telefon')
                            ->default('—'),
                        TextEntry::make('created_at')
                            ->label('Gönderim Tarihi')
                            ->dateTime('d.m.Y H:i'),
                        IconEntry::make('is_read')
                            ->label('Okundu')
                            ->boolean(),
                    ])
                    ->columns(2),

                Section::make('Mesaj İçeriği')
                    ->schema([
                        TextEntry::make('message')
                            ->label('')
                            ->columnSpanFull()
                            ->prose(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Sil'),
        ];
    }
}

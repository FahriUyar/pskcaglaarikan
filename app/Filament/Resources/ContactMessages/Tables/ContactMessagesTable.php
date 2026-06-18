<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Durum')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),
                TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable()
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->toggleable(),
                TextColumn::make('message')
                    ->label('Mesaj')
                    ->limit(60),
                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Durum')
                    ->options([
                        '0' => 'Okunmadı',
                        '1' => 'Okundu',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data, $record): array {
                        if (! $record->is_read) {
                            $record->markAsRead();
                        }
                        return $data;
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ]),
            ]);
    }
}

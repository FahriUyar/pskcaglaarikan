<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->sortable(),
                TextColumn::make('key')
                    ->label('Anahtar')
                    ->searchable(),
                TextColumn::make('value')
                    ->label('Değer')
                    ->limit(50)
                    ->searchable(),
            ])
            ->defaultSort('group')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}

<?php

namespace App\Filament\Resources\Certificates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class CertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('Önizleme')
                    ->html()
                    ->formatStateUsing(fn ($state) => str_ends_with($state, '.pdf') 
                        ? '<div style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;background-color:#f3f4f6;color:#dc2626;border-radius:8px;font-weight:bold;font-size:12px;border:1px solid #e5e7eb;">PDF</div>'
                        : '<img src="' . \Illuminate\Support\Facades\Storage::url($state) . '" style="width:40px;height:40px;border-radius:8px;object-fit:cover;">'
                    ),
                TextColumn::make('title')
                    ->label('Sertifika Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('institution')
                    ->label('Veren Kurum')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Tarih')
                    ->date('d.m.Y')
                    ->sortable(),
                TextInputColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ]),
            ]);
    }
}

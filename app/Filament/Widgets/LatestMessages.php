<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessages extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Son Gelen Mesajlar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Gönderen'),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Konu')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Okundu')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                \Filament\Actions\Action::make('view')
                    ->label('Görüntüle')
                    ->icon('heroicon-m-eye')
                    ->url(fn (ContactMessage $record): string => url('/admin/contact-messages/' . $record->id . '/edit'))
            ])
            ->paginated(false);
    }
}

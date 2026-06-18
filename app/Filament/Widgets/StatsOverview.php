<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Okunmamış Mesajlar', $unreadMessages)
                ->description($unreadMessages > 0 ? 'Yeni mesajlarınız var' : 'Tüm mesajlar okundu')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadMessages > 0 ? 'danger' : 'success'),
                
            Stat::make('Aktif Hizmetler', Service::count())
                ->description('Toplam hizmet sayısı')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),
                
            Stat::make('Blog Yazıları', Post::count())
                ->description('Yayınlanan içerik sayısı')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}

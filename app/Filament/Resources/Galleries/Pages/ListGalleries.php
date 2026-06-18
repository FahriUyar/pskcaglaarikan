<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use App\Models\Gallery;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bulk_upload')
                ->label('Toplu Yükle')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    FileUpload::make('images')
                        ->label('Yüklenecek Görseller')
                        ->image()
                        ->multiple()
                        ->directory('gallery')
                        ->required()
                        ->maxSize(5120)
                ])
                ->action(function (array $data): void {
                    $images = $data['images'] ?? [];

                    if (empty($images)) {
                        return;
                    }

                    $count = 0;
                    foreach ($images as $imagePath) {
                        Gallery::create([
                            'image' => $imagePath,
                            'title' => null,
                            'alt_text' => null,
                            'sort_order' => 0,
                            'is_active' => true,
                        ]);
                        $count++;
                    }

                    Notification::make()
                        ->title("{$count} görsel başarıyla eklendi!")
                        ->success()
                        ->send();
                }),
            CreateAction::make()
                ->label('Tekli Görsel Ekle'),
        ];
    }
}

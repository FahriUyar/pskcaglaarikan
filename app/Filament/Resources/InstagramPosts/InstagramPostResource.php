<?php

namespace App\Filament\Resources\InstagramPosts;

use App\Filament\Resources\InstagramPosts\Pages\ManageInstagramPosts;
use App\Models\InstagramPost;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstagramPostResource extends Resource
{
    protected static ?string $model = InstagramPost::class;

    protected static ?string $modelLabel = 'Instagram Gönderisi';
    protected static ?string $pluralModelLabel = 'Instagram Gönderileri';
    protected static ?int $navigationSort = 5;
    protected static string | \UnitEnum | null $navigationGroup = 'Site Yönetimi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('image_path')
                    ->label('Gönderi Görseli')
                    ->image()
                    ->required()
                    ->directory('instagram')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                \Filament\Forms\Components\TextInput::make('url')
                    ->label('Instagram Gönderi Linki')
                    ->url()
                    ->nullable()
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Aktif mi?')
                    ->default(true),
                \Filament\Forms\Components\TextInput::make('sort_order')
                    ->label('Sıralama')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image_path')
                    ->label('Görsel')
                    ->square(),
                \Filament\Tables\Columns\TextColumn::make('url')
                    ->label('Bağlantı')
                    ->limit(30)
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                \Filament\Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                \Filament\Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıralama')
                    ->sortable(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageInstagramPosts::route('/'),
        ];
    }
}

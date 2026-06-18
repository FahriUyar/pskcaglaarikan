<?php

namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages\ManageFaqs;
use App\Models\Faq;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $modelLabel = 'Sıkça Sorulan Soru';
    protected static ?string $pluralModelLabel = 'SSS';
    protected static ?int $navigationSort = 4;
    protected static string | \UnitEnum | null $navigationGroup = 'Site Yönetimi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('question')
                    ->label('Soru')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('answer')
                    ->label('Cevap')
                    ->required()
                    ->rows(4)
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
                \Filament\Tables\Columns\TextColumn::make('question')
                    ->label('Soru')
                    ->searchable()
                    ->limit(50),
                \Filament\Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                \Filament\Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıralama')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageFaqs::route('/'),
        ];
    }
}

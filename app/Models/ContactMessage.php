<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
    ];

    /**
     * Attribute dönüşümleri.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Scope'lar                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Sadece okunmamış mesajları filtreler.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * Sadece okunmuş mesajları filtreler.
     */
    public function scopeRead(Builder $query): Builder
    {
        return $query->where('is_read', true);
    }

    /**
     * Mesajı okundu olarak işaretler.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Mesajı okunmadı olarak işaretler.
     */
    public function markAsUnread(): void
    {
        $this->update(['is_read' => false]);
    }
}

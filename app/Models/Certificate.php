<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'institution',
        'image',
        'date',
        'sort_order',
        'is_active',
    ];

    /**
     * Attribute dönüşümleri.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'date' => 'date',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Scope'lar                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Sadece aktif sertifikaları filtreler.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Sıralama alanına göre sıralar.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}

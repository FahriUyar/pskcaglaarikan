<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'body',
        'icon',
        'cover_image',
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
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Scope'lar                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Sadece aktif hizmetleri filtreler.
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

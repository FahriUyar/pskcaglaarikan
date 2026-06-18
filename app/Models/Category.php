<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
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
    /*  İlişkiler                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Bu kategoriye ait blog yazıları.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Scope'lar                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Sadece aktif kategorileri filtreler.
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    /**
     * Attribute dönüşümleri.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  İlişkiler                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Yazının ait olduğu kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Scope'lar                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Sadece yayınlanmış ve tarihi geçmiş yazıları filtreler.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Sadece taslak yazıları filtreler.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * En yeni yazıdan başlayarak sıralar.
     */
    public function scopeLatestPublished(Builder $query): Builder
    {
        return $query->published()->orderByDesc('published_at');
    }
}

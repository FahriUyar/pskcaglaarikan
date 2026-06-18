<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Belirtilen anahtarın değerini döndürür.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Belirtilen anahtarın değerini günceller veya yeni kayıt oluşturur.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group],
        );
    }

    /**
     * Belirtilen gruptaki tüm ayarları key => value olarak döndürür.
     *
     * @return array<string, string|null>
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}

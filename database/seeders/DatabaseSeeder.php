<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin kullanıcı
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        // Varsayılan site ayarları
        $this->call([
            SettingsSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Varsayılan site ayarlarını oluşturur.
     */
    public function run(): void
    {
        $settings = [
            // İletişim Bilgileri
            ['key' => 'phone', 'value' => null, 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => null, 'group' => 'contact'],
            ['key' => 'email', 'value' => null, 'group' => 'contact'],
            ['key' => 'address', 'value' => null, 'group' => 'contact'],
            ['key' => 'map_embed', 'value' => null, 'group' => 'contact'],

            // Sosyal Medya
            ['key' => 'instagram', 'value' => null, 'group' => 'social'],
            ['key' => 'facebook', 'value' => null, 'group' => 'social'],
            ['key' => 'twitter', 'value' => null, 'group' => 'social'],
            ['key' => 'linkedin', 'value' => null, 'group' => 'social'],
            ['key' => 'youtube', 'value' => null, 'group' => 'social'],

            // Genel Ayarlar
            ['key' => 'site_title', 'value' => 'Psikolog Çağla Arıkan', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Uzman Psikolog Çağla Arıkan - Bireysel ve aile terapisi', 'group' => 'general'],
            ['key' => 'logo', 'value' => null, 'group' => 'general'],
            ['key' => 'favicon', 'value' => null, 'group' => 'general'],
            ['key' => 'about_text', 'value' => null, 'group' => 'general'],
            ['key' => 'about_image', 'value' => null, 'group' => 'general'],

            // Hakkımda Sayfası Detayları
            ['key' => 'about_approach_title', 'value' => 'Terapötik Yaklaşım', 'group' => 'about'],
            ['key' => 'about_approach_text', 'value' => 'Güvenli ve dingin bir alanda; canlılık, temas ve duygusal hareketi merkeze alan bütüncül bir süreç.', 'group' => 'about'],
            ['key' => 'about_values', 'value' => '["Kişiye özgü terapi çerçevesi","Danışanın temposuna saygı","Bilimsel ve samimi ilişki zemini","Kültürel çeşitliliğe duyarlık"]', 'group' => 'about'],

            // İletişim Sayfası
            ['key' => 'contact_page_title', 'value' => 'İletişime Geçin', 'group' => 'contact'],
            ['key' => 'contact_page_description', 'value' => 'Sorularınız veya randevu talepleriniz için aşağıdaki formu doldurabilir ya da iletişim bilgilerimden bana ulaşabilirsiniz.', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting,
            );
        }
    }
}

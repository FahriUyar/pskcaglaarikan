# Psikolog Çağla Arıkan - Profesyonel Danışmanlık Web Sitesi

Modern, hızlı ve SEO uyumlu bir altyapıya sahip, psikolojik danışmanlık hizmetleri için özel olarak geliştirilmiş kurumsal web projesi. 

## 🚀 Proje Hakkında
Bu proje, Psikolog Çağla Arıkan'ın dijital dünyadaki yüzü olarak tasarlanmıştır. Danışanların hizmetler hakkında detaylı bilgi alabileceği, yayınlanan makaleleri (blog) okuyabileceği ve kurum içi sertifika/galeri gibi detaylara güvenle erişebileceği, tüm cihazlarla %100 uyumlu bir web uygulamasıdır.

Gelişmiş admin paneli sayesinde sitenin içerisindeki bütün ayarlar, yazılar, fotoğraflar ve SEO metinleri kodlama bilgisi gerektirmeden dinamik bir şekilde yönetilebilir.

## ✨ Temel Özellikler
*   **Gelişmiş Admin Paneli (Filament v3):** Tüm içeriklerin, galeri görsellerinin, sertifikaların ve site genel ayarlarının (logo, iletişim, sosyal medya) tek bir noktadan pratik şekilde yönetimi.
*   **Tamamen Dinamik SEO:** Her sayfa için otomatik oluşturulan `Title`, `Meta Description` etiketleri; WhatsApp, Twitter ve Instagram paylaşımlarında zengin görünüm sağlayan **Open Graph** yapılandırması.
*   **Modern ve Responsive Tasarım:** Vanilla CSS ve Bootstrap kullanılarak mobil cihazlardan masaüstü monitörlere kadar her ekranda kusursuz görünen, erişilebilirliği (A11y) yüksek tasarım.
*   **Hafif ve Hızlı:** Optimize edilmiş görsel yüklemeleri (WebP formatı ve tembel yükleme - Lazy Load) ile Lighthouse'da yüksek performans skorları.
*   **Blog ve Makale Yönetimi:** Psikoloji alanındaki makalelerin zengin metin editörü (Rich Text) ile eklenebileceği, yayın durumlarının ve kapak görsellerinin yönetilebileceği dinamik blog sistemi.
*   **Gelişmiş Medya Yönetimi:** GLightbox entegrasyonu ile sayfa değiştirmeden, kaydırma ve büyütme destekli interaktif resim galerisi ve sertifika görüntüleyici.

## 🛠 Kullanılan Teknolojiler

*   **Backend:** Laravel 13, PHP 8.3+, SQLite (Canlı ortamda tercihe bağlı MySQL)
*   **Frontend:** Blade Şablon Motoru, Bootstrap 5, Vanilla JS, GLightbox
*   **Yönetim Paneli:** Filament PHP v3
*   **Asset Yönetimi:** Vite
*   **Veritabanı:** Eloquent ORM 

## ⚙️ Kurulum (Geliştiriciler İçin)

Projeyi bilgisayarınızda çalıştırmak için aşağıdaki adımları izleyebilirsiniz:

1. Depoyu bilgisayarınıza klonlayın:
```bash
git clone https://github.com/FahriUyar/pskcaglaarikan.git
```

2. Gerekli kütüphaneleri (bağımlılıkları) kurun:
```bash
composer install
npm install
```

3. `.env` dosyasını oluşturun ve şifreleme anahtarını üretin:
```bash
cp .env.example .env
php artisan key:generate
```

4. Veritabanını oluşturun ve örnek verileri (gerekliyse) yükleyin:
```bash
touch database/database.sqlite
php artisan migrate
```

5. Storage klasörünün kısayol bağlantısını (symlink) oluşturun:
```bash
php artisan storage:link
```

6. Frontend dosyalarını derleyin ve geliştirme sunucusunu başlatın:
```bash
npm run build
php artisan serve
```

---
*Geliştirici:* [Fahri Uyar](https://github.com/FahriUyar)

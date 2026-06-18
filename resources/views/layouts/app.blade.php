<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
    $siteTitle = App\Models\Setting::get('site_title', 'Psikolog Çağla Arıkan');
    $siteDesc = App\Models\Setting::get('site_description', 'Bireysel ve Çift Terapisi Danışmanlık Hizmetleri');

    $pageTitle = isset($title) ? $title . ' - ' . $siteTitle : $siteTitle;
    $pageDesc = $description ?? $siteDesc;
    $pageImage = $ogImage ?? asset('images/default-og.webp');
    $favicon = App\Models\Setting::get('favicon');
    $logo = App\Models\Setting::get('logo');
    $aboutImage = App\Models\Setting::get('about_image');
    $schemaImageUrl = $aboutImage ? Storage::url($aboutImage) : ($logo ? Storage::url($logo) : $pageImage);
    @endphp

    <!-- Dinamik Meta ve SEO Etiketleri -->
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    @if($favicon)
    <link rel="icon" href="{{ Storage::url($favicon) }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph & Twitter Cards -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:image" content="{{ $pageImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $pageImage }}">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @stack('styles')

    <!-- Schema.org / Structured Data (Google'da Resimli Çıkma İhtimalini Artırır) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Physician",
      "name": "{{ $siteTitle }}",
      "image": "{{ $schemaImageUrl }}",
      "description": "{{ $siteDesc }}",
      "url": "{{ url()->current() }}",
      "telephone": "{{ App\Models\Setting::get('phone') }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ App\Models\Setting::get('address') }}",
        "addressCountry": "TR"
      }
    }
    </script>
</head>

<body>

    <!-- Header / Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" aria-label="Ana Sayfa">
                    @if($logo)
                    <img src="{{ Storage::url($logo) }}" alt="{{ $siteTitle }}" style="max-height: 100px; width: auto;" class="d-inline-block align-middle">
                    @else
                    {{ $siteTitle }}
                    @endif
                </a>
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menüyü Aç">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Ana Sayfa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('hakkimda') ? 'active' : '' }}" href="{{ url('/hakkimda') }}">Hakkımda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('hizmetler*') ? 'active' : '' }}" href="{{ url('/hizmetler') }}">Hizmetler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('/blog') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('sertifikalar') ? 'active' : '' }}" href="{{ url('/sertifikalar') }}">Sertifikalar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('iletisim') ? 'active' : '' }}" href="{{ url('/iletisim') }}">İletişim</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/iletisim') }}" class="btn btn-primary d-flex align-items-center gap-2" aria-label="Randevu Al">
                            <i class="bi bi-calendar-check" aria-hidden="true"></i> Randevu Al
                        </a>
                        @if($whatsapp = App\Models\Setting::get('whatsapp'))
                        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success d-flex align-items-center justify-content-center" aria-label="WhatsApp üzerinden iletişime geçin" style="width: 42px; height: 42px; border-radius: 50%;">
                            <i class="bi bi-whatsapp fs-5" aria-hidden="true"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main style="margin-top: 80px; min-height: 70vh;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="footer-title">{{ $siteTitle }}</h4>
                    <p class="text-muted-custom mb-4">{{ $siteDesc }}</p>
                    <div class="d-flex gap-3">
                        @if($instagram = App\Models\Setting::get('instagram'))
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="text-muted-custom fs-4" aria-label="Instagram profilimiz"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                        @endif
                        @if($linkedin = App\Models\Setting::get('linkedin'))
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" class="text-muted-custom fs-4" aria-label="LinkedIn profilimiz"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">Hızlı Bağlantılar</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/hakkimda') }}" class="footer-link">Hakkımda</a></li>
                        <li><a href="{{ url('/hizmetler') }}" class="footer-link">Hizmetlerimiz</a></li>
                        <li><a href="{{ url('/blog') }}" class="footer-link">Blog</a></li>
                        <li><a href="{{ url('/sertifikalar') }}" class="footer-link">Sertifikalar</a></li>
                        <li><a href="{{ url('/galeri') }}" class="footer-link">Galeri</a></li>
                        <li><a href="{{ url('/iletisim') }}" class="footer-link">İletişim</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h5 class="footer-title">İletişim</h5>
                    <ul class="list-unstyled text-muted-custom">
                        @if($phone = App\Models\Setting::get('phone'))
                        <li class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-telephone text-primary" aria-hidden="true"></i>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-decoration-none text-muted-custom">{{ $phone }}</a>
                        </li>
                        @endif
                        @if($email = App\Models\Setting::get('email'))
                        <li class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-primary" aria-hidden="true"></i>
                            <a href="mailto:{{ $email }}" class="text-decoration-none text-muted-custom">{{ $email }}</a>
                        </li>
                        @endif
                        @if($address = App\Models\Setting::get('address'))
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt text-primary mt-1" aria-hidden="true"></i>
                            <span>{{ $address }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <hr class="mt-4 mb-4 text-muted">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted-custom small">&copy; {{ date('Y') }} {{ $siteTitle }}. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Mobil Menü (Hamburger) Garantili Açma/Kapatma
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.querySelector('.navbar-toggler');
            const target = document.getElementById('mainNavbar');
            if (toggler && target) {
                toggler.addEventListener('click', function(e) {
                    target.classList.toggle('show');
                    toggler.classList.toggle('collapsed');
                    const isExpanded = toggler.getAttribute('aria-expanded') === 'true';
                    toggler.setAttribute('aria-expanded', !isExpanded);
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
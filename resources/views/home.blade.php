@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden section-padding mt-0">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="badge bg-white text-primary mb-3 px-3 py-2 fw-medium shadow-sm">Bireysel & Çift Terapisi</span>
                <h1 class="display-4 fw-bold mb-4" style="color: var(--bs-heading-color);">{!! $heroTitle !!}</h1>
                <p class="lead text-muted-custom mb-5 pe-lg-5">{{ $heroText }}</p>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ url('/iletisim') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                        Hemen Randevu Al <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url('/hizmetler') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                        Çalışma Alanları
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
                @if($aboutImage)
                    <img src="{{ Storage::url($aboutImage) }}" alt="Psikolog Çağla Arıkan" class="img-fluid rounded-4 shadow-lg" loading="eager" style="max-height: 580px; object-fit: cover;">
                @else
                    <div class="bg-white rounded-4 shadow-lg d-flex align-items-center justify-content-center mx-auto" style="height: 580px; max-width: 450px; border: 1px solid rgba(0,0,0,0.05);">
                        <i class="bi bi-image text-muted" style="font-size: 5rem; opacity: 0.2;" aria-hidden="true"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Kısaca Hakkımda Section -->
@if($aboutText)
<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="mb-4">Hakkımda</h2>
                <div class="text-muted-custom fs-5 mb-4">
                    {{ Str::limit(strip_tags($aboutText), 350) }}
                </div>
                <a href="{{ url('/hakkimda') }}" class="btn btn-outline-primary fw-medium">Detaylı Özgeçmiş</a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Hizmetlerimiz Section -->
@if($services->count() > 0)
<section class="section-padding" style="background-color: var(--bs-body-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-primary fw-medium mb-2 d-block">Hizmetler</span>
            <h2 class="display-6 fw-bold">Çalışma Alanları</h2>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 p-2">
                    <div class="card-body">
                        <div class="icon-wrap bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                            <i class="bi bi-activity fs-3" aria-hidden="true"></i>
                        </div>
                        <h3 class="h4 card-title fw-bold mb-3">{{ $service->title }}</h3>
                        <p class="card-text text-muted-custom">{{ $service->description }}</p>
                    </div>
                    <!--<div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
                        <a href="{{ url('/hizmetler/' . $service->slug) }}" class="text-primary text-decoration-none fw-medium d-inline-flex align-items-center">
                            İncele <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                        </a>
                    </div>-->
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Son Yazılar Section -->
@if($latestPosts->count() > 0)
<section class="section-padding bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="text-primary fw-medium mb-2 d-block">Güncel Yazılar</span>
                <h2 class="display-6 fw-bold mb-0">Blog</h2>
            </div>
            <a href="{{ url('/blog') }}" class="btn btn-outline-primary d-none d-md-inline-block">Tümünü Gör</a>
        </div>
        
        <div class="row g-4">
            @foreach($latestPosts as $post)
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 overflow-hidden">
                    @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                            <i class="bi bi-image text-muted fs-1" aria-hidden="true"></i>
                        </div>
                    @endif
                    <div class="card-body p-4">
                        @if($post->category)
                            <span class="badge bg-secondary mb-3">{{ $post->category->name }}</span>
                        @endif
                        <h3 class="h5 card-title fw-bold mb-3">
                            <a href="{{ url('/blog/' . $post->slug) }}" class="text-decoration-none" style="color: var(--bs-heading-color);">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="card-text text-muted-custom small mb-4">
                            {{ Str::limit($post->excerpt ?? strip_tags($post->body), 100) }}
                        </p>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-calendar3 me-2" aria-hidden="true"></i>
                            <time datetime="{{ $post->published_at->toIso8601String() }}">
                                {{ $post->published_at->format('d.m.Y') }}
                            </time>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5 d-md-none">
            <a href="{{ url('/blog') }}" class="btn btn-outline-primary w-100">Tüm Yazıları Gör</a>
        </div>
    </div>
</section>
@endif

<!-- SSS (Sıkça Sorulan Sorular) -->
@if(isset($faqs) && $faqs->isNotEmpty())
<section class="section-padding bg-soft-primary" aria-label="Sıkça Sorulan Sorular">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold">Sıkça Sorulan Sorular</h2>
            <p class="text-muted-custom">Terapi süreciyle ilgili en çok merak edilenler</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item bg-transparent border-bottom">
                        <h2 class="accordion-header" id="faq-heading-{{ $faq->id }}">
                            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }} bg-transparent fw-semibold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-{{ $faq->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="faq-collapse-{{ $faq->id }}" style="box-shadow: none;">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq-collapse-{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="faq-heading-{{ $faq->id }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted-custom pb-4">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Yorumlar (Testimonials) -->
<section class="section-padding" aria-label="Danışan Yorumları">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold">Danışan Deneyimleri</h2>
            <p class="text-muted-custom">Süreci birlikte yürüttüğümüz danışanlarımızın geri bildirimleri</p>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Yorum 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 p-4" style="background-color: #fdfcf9; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
                    <div class="text-warning mb-3 fs-5">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="fst-italic text-muted-custom mb-4" style="line-height: 1.8;">"Çağla Hanım ile seanslara başladığımda kendimi çok karanlık bir yerde hissediyordum. Yargılamadan dinleyişi ve profesyonel yaklaşımı sayesinde kısa sürede kendi içimdeki gücü fark ettim. İyi ki yollarımız kesişmiş."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; background: var(--theme-primary);">M.K.</div>
                        <div class="ms-3">
                            <h4 class="h6 mb-0 fw-bold">M*** K***</h4>
                            <span class="small text-muted-custom">Bireysel Terapi Danışanı</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Yorum 2 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 p-4" style="background-color: #fdfcf9; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
                    <div class="text-warning mb-3 fs-5">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="fst-italic text-muted-custom mb-4" style="line-height: 1.8;">"Eşimle aşılmaz sandığımız sorunlarımız vardı. Çift terapisi sayesinde birbirimizi gerçekten dinlemeyi ve doğru iletişim kurmayı öğrendik. Seansların her dakikası çok kıymetliydi, ilişkimize nefes aldırdı."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; background: var(--bs-secondary);">A.Y.</div>
                        <div class="ms-3">
                            <h4 class="h6 mb-0 fw-bold">A*** Y***</h4>
                            <span class="small text-muted-custom">Çift Terapisi Danışanı</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yorum 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 p-4" style="background-color: #fdfcf9; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
                    <div class="text-warning mb-3 fs-5">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="fst-italic text-muted-custom mb-4" style="line-height: 1.8;">"Uzun zamandır boğuştuğum anksiyete atakları için destek aldım. Sorunların kökenine inerek uyguladığı bilimsel yöntemler günlük hayatımı inanılmaz rahatlattı. Alanında son derece uzman ve güven veren bir psikolog."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; background: var(--theme-primary);">S.E.</div>
                        <div class="ms-3">
                            <h4 class="h6 mb-0 fw-bold">S*** E***</h4>
                            <span class="small text-muted-custom">Bireysel Terapi Danışanı</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Akışı -->
@if(isset($instagramPosts) && $instagramPosts->isNotEmpty())
<section class="section-padding bg-light" aria-label="Instagram">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5">
            <div class="mb-4 mb-md-0">
                <h2 class="display-6 fw-bold">Instagram'da Biz</h2>
                <p class="text-muted-custom mb-0">Güncel paylaşımlarımıza ve bilgilendirici içeriklere ulaşabilirsiniz</p>
            </div>
            @if($instagram = App\Models\Setting::get('instagram'))
            <div class="d-none d-md-block">
                <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary d-inline-flex align-items-center">
                    <i class="bi bi-instagram me-2"></i>Takip Et
                </a>
            </div>
            @endif
        </div>

        <div class="row g-4">
            @foreach($instagramPosts as $post)
            <div class="col-6 col-lg-3">
                <a href="{{ $post->url ?? App\Models\Setting::get('instagram') }}" target="_blank" rel="noopener noreferrer" class="d-block position-relative overflow-hidden rounded-4 instagram-card" style="aspect-ratio: 1/1; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <img src="{{ Storage::url($post->image_path) }}" alt="Instagram Post" class="w-100 h-100 object-fit-cover" loading="lazy" style="transition: transform 0.5s ease;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center instagram-overlay" style="background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.3s ease;">
                        <i class="bi bi-instagram text-white fs-2"></i>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        @if($instagram = App\Models\Setting::get('instagram'))
        <div class="text-center mt-5 d-md-none">
            <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary w-100 d-inline-flex justify-content-center align-items-center">
                <i class="bi bi-instagram me-2"></i>Takip Et
            </a>
        </div>
        @endif
    </div>
</section>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const targetContent = document.querySelector(targetId);
            
            if (!targetContent) return;

            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const parentId = this.getAttribute('data-bs-parent');
            
            if (parentId) {
                const parent = document.querySelector(parentId);
                if (parent) {
                    const allButtons = parent.querySelectorAll('.accordion-button');
                    const allContents = parent.querySelectorAll('.accordion-collapse');
                    
                    allButtons.forEach(btn => {
                        if (btn !== this) {
                            btn.setAttribute('aria-expanded', 'false');
                            btn.classList.add('collapsed');
                        }
                    });
                    
                    allContents.forEach(content => {
                        if (content !== targetContent) {
                            content.classList.remove('show');
                        }
                    });
                }
            }
            
            if (isExpanded) {
                this.setAttribute('aria-expanded', 'false');
                this.classList.add('collapsed');
                targetContent.classList.remove('show');
            } else {
                this.setAttribute('aria-expanded', 'true');
                this.classList.remove('collapsed');
                targetContent.classList.add('show');
            }
        });
    });
});
</script>
@endpush

@endsection

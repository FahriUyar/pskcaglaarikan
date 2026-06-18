@extends('layouts.app')

@php
$title = 'Hizmetlerimiz';
$description = 'Psikolog Çağla Arıkan danışmanlık hizmetleri. Çocuk, ergen, yetişkin danışmanlığı ve daha fazlası.';
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero" aria-labelledby="services-heading">
    <div class="container position-relative">
        <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">Çalışma Alanları</span>
        <h1 id="services-heading">İhtiyacınıza Uygun<br>Danışmanlık Çerçevesi</h1>
        <p class="text-muted-custom">
            Danışanlarıma aşağıdaki alanlarda profesyonel destek sunuyorum.
        </p>
    </div>
</section>

<!-- Hizmet Kartları -->
<section class="section-padding p-4" aria-label="Hizmet listesi">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($services as $index => $service)
            <div class="col-lg-4 col-md-6">
                <article class="service-card fade-up delay-{{ ($index % 6) + 1 }}">
                    <div class="icon-wrap" aria-hidden="true">
                        <i class="bi bi-activity"></i>
                    </div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->description }}</p>
                    @if($service->body)
                    <a href="{{ route('services.detail', $service->slug) }}" class="card-link">
                        Detayları İncele <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                    @endif
                </article>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted-custom">
                    <i class="bi bi-inbox fs-1 d-block mb-3" aria-hidden="true"></i>
                    <p>Henüz hizmet eklenmedi.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Bölümü -->
<section class="section-padding bg-soft-primary" aria-label="Randevu alma çağrısı">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-7 fade-up">
                <h2 class="display-6 fw-bold mb-3">Profesyonel Destek Almaya Hazır mısınız?</h2>
                <p class="text-muted-custom fs-5 mb-4">İlk adımı atmak zor olabilir, ancak yanınızda güvenilir bir yol arkadaşı olacak.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ url('/iletisim') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-calendar-check me-2" aria-hidden="true"></i> Randevu Al
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg px-4">
                        İletişime Geç
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    });
</script>
@endpush
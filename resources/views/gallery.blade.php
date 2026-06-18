@extends('layouts.app')

@php
$title = 'Galeri';
$description = 'Klinik ortamımız ve çalışma alanlarımızdan görseller.';
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero" aria-labelledby="gallery-heading">
    <div class="container position-relative">
        <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">Galeri</span>
        <h1 id="gallery-heading">Çalışma Alanımız</h1>
        <p class="text-muted-custom">
            Klinik ortamımız ve terapötik çalışma alanlarımızdan görseller.
        </p>
    </div>
</section>

<!-- Galeri Grid -->
<section class="section-padding p-4" aria-label="Galeri görselleri">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($galleries as $index => $gallery)
            <div class="col-lg-4 col-md-6">
                <article class="certificate-card fade-up delay-{{ ($index % 6) + 1 }}">
                    <a href="{{ Storage::url($gallery->image) }}"
                        class="glightbox cert-image-wrap d-block position-relative"
                        data-gallery="gallery-images"
                        data-title="{{ $gallery->title }}"
                        data-description="{{ $gallery->alt_text ?? '' }}">
                        <img src="{{ Storage::url($gallery->image) }}"
                            alt="{{ $gallery->alt_text ?? $gallery->title }}"
                            width="400" height="300"
                            style="object-fit: cover; aspect-ratio: 4/3; width: 100%;"
                            loading="lazy">
                        <div class="cert-overlay" aria-hidden="true">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </a>
                    @if($gallery->title)
                    <div class="cert-body text-center p-3">
                        <h3 class="h6 mb-0">{{ $gallery->title }}</h3>
                    </div>
                    @endif
                </article>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted-custom">
                    <i class="bi bi-images fs-1 d-block mb-3" aria-hidden="true"></i>
                    <p>Henüz galeriye görsel eklenmedi.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Scroll Reveal
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

        // GLightbox Initialization
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            zoomable: true
        });
    });
</script>
@endpush

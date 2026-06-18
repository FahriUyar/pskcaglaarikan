@extends('layouts.app')

@php
$title = 'Sertifikalar';
$description = 'Psikolog Çağla Arıkan eğitim ve katılım belgeleri. Mesleki gelişim sertifikaları.';
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero" aria-labelledby="certs-heading">
    <div class="container position-relative">
        <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">Sertifikalar</span>
        <h1 id="certs-heading">Eğitim ve Katılım Belgeleri</h1>
        <p class="text-muted-custom">
            Mesleki gelişim sürecimde aldığım eğitimlere ve katıldığım programlara ait belgeler.
        </p>
    </div>
</section>

<!-- Sertifika Grid -->
<section class="section-padding p-4" aria-label="Sertifika listesi">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($certificates as $index => $certificate)
            <div class="col-lg-4 col-md-6">
                <article class="certificate-card fade-up delay-{{ ($index % 6) + 1 }}">
                    @if(Str::endsWith($certificate->image, '.pdf'))
                    <div class="cert-image-wrap bg-white">
                        <iframe src="{{ Storage::url($certificate->image) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                            width="100%" height="100%"
                            style="border: none; pointer-events: none;"
                            tabindex="-1"></iframe>
                        <a href="{{ Storage::url($certificate->image) }}" target="_blank" rel="noopener noreferrer" class="cert-overlay" aria-label="PDF'i Yeni Sekmede Aç">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                    @else
                    <div class="cert-image-wrap"
                        role="button"
                        tabindex="0"
                        aria-label="{{ $certificate->title }} sertifikasını büyüt"
                        data-lightbox-src="{{ Storage::url($certificate->image) }}"
                        data-lightbox-alt="{{ $certificate->title }}">
                        <img src="{{ Storage::url($certificate->image) }}"
                            alt="{{ $certificate->title }} sertifika görseli"
                            width="400" height="300"
                            style="object-fit: cover;"
                            loading="lazy">
                        <div class="cert-overlay" aria-hidden="true">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </div>
                    @endif
                    <div class="cert-body">
                        <h3>{{ $certificate->title }}</h3>
                        <div class="cert-meta">
                            @if($certificate->institution)
                            <span>{{ $certificate->institution }}</span>
                            @endif
                            @if($certificate->institution && $certificate->date)
                            <span aria-hidden="true">•</span>
                            @endif
                            @if($certificate->date)
                            <time datetime="{{ $certificate->date->toDateString() }}">
                                {{ $certificate->date->format('d.m.Y') }}
                            </time>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted-custom">
                    <i class="bi bi-award fs-1 d-block mb-3" aria-hidden="true"></i>
                    <p>Henüz sertifika eklenmedi.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Lightbox Dialog (Native) -->
<dialog id="cert-lightbox" class="cert-lightbox" aria-label="Sertifika büyütülmüş görünüm">
    <button type="button" class="lightbox-close" aria-label="Kapat">
        <i class="bi bi-x-lg" aria-hidden="true"></i>
    </button>
    <img src="" alt="" loading="lazy">
</dialog>

@endsection

@push('scripts')
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

        // Lightbox — Native <dialog>
        const lightbox = document.getElementById('cert-lightbox');
        const lightboxImg = lightbox.querySelector('img');
        const lightboxClose = lightbox.querySelector('.lightbox-close');

        document.querySelectorAll('[data-lightbox-src]').forEach(trigger => {
            const openLightbox = () => {
                lightboxImg.src = trigger.dataset.lightboxSrc;
                lightboxImg.alt = trigger.dataset.lightboxAlt || '';
                lightbox.showModal();
            };

            trigger.addEventListener('click', openLightbox);
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openLightbox();
                }
            });
        });

        lightboxClose.addEventListener('click', () => lightbox.close());

        // Backdrop click to close
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) lightbox.close();
        });
    });
</script>
@endpush
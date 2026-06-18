@extends('layouts.app')

@php
    $title = 'Hakkımda';
    $description = 'Psikolog Çağla Arıkan hakkında bilgi edinin. Eğitim, deneyim ve terapötik yaklaşım.';
@endphp

@section('content')

<!-- Hero Bölümü -->
<section class="about-hero pb-5" aria-labelledby="about-heading">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">Psikolog</span>
                <h1 id="about-heading" class="display-5 fw-bold mb-3">Çağla Arıkan</h1>
                <p class="text-muted-custom fs-5 mb-0">Psikolog — Bireysel Danışmanlık</p>
                @if($aboutHeroDesc)
                    <p class="mt-4 text-muted fs-6" style="max-width: 500px;">{{ $aboutHeroDesc }}</p>
                @endif
            </div>
            <div class="col-lg-5 col-md-8 text-center">
                @if($aboutImage)
                    <img src="{{ Storage::url($aboutImage) }}"
                         alt="Psikolog Çağla Arıkan portre fotoğrafı"
                         class="about-hero-image img-fluid rounded-4 shadow-lg"
                         style="max-height: 500px; object-fit: cover;"
                         loading="eager">
                @else
                    <div class="image-placeholder rounded-top-4 mx-auto" style="height: 400px; max-width: 400px;">
                        <i class="bi bi-person" aria-hidden="true"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Ana İçerik -->
<section class="section-padding" aria-label="Hakkımda detayları">
    <div class="container">
        <div class="row g-5">

            <!-- Sol: Metin İçerik -->
            <div class="col-lg-8">
                <article class="about-body fade-up">
                    @if($aboutText)
                        {!! $aboutText !!}
                    @else
                        <p>Henüz içerik eklenmedi. Admin panelinden "Hakkımda" metnini düzenleyebilirsiniz.</p>
                    @endif
                </article>
            </div>

            <!-- Sağ: Sidebar Kartları -->
            <aside class="col-lg-4">
                <!-- Terapötik Yaklaşım Kartı -->
                @if($approachText)
                <div class="sidebar-card mb-4 fade-up delay-1">
                    <h3>
                        <i class="bi bi-heart-pulse" aria-hidden="true"></i>
                        {{ $approachTitle }}
                    </h3>
                    <p class="mb-0">{{ $approachText }}</p>
                </div>
                @endif

                <!-- Değerlerim Kartı -->
                @if(count($aboutValues) > 0)
                <div class="sidebar-card fade-up delay-2">
                    <h3>
                        <i class="bi bi-gem" aria-hidden="true"></i>
                        Değerlerim
                    </h3>
                    <ul class="values-list">
                        @foreach($aboutValues as $value)
                            <li>{{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </aside>

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
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    });
</script>
@endpush

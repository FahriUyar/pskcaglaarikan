@extends('layouts.app')

@php
    $title = $service->title;
    $description = $service->description ?? $service->title . ' hakkında detaylı bilgi.';
    $ogImage = $service->cover_image ? Storage::url($service->cover_image) : null;
@endphp

@section('content')

<!-- Breadcrumb -->
<section class="pt-4 pb-0">
    <div class="container">
        <nav class="breadcrumb-nav" aria-label="İçerik haritası">
            <ol>
                <li><a href="{{ route('home') }}">Ana Sayfa</a></li>
                <li><a href="{{ route('services') }}">Hizmetler</a></li>
                <li aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Hizmet Detay -->
<section class="section-padding pt-0" aria-labelledby="service-detail-heading">
    <div class="container">
        <div class="row g-5">

            <!-- Sol: Ana İçerik -->
            <div class="col-lg-8">
                @if($service->cover_image)
                <figure class="service-detail-cover fade-up">
                    <img src="{{ Storage::url($service->cover_image) }}"
                         alt="{{ $service->title }} kapak görseli"
                         width="800" height="400"
                         loading="eager">
                </figure>
                @endif

                <h1 id="service-detail-heading" class="display-6 fw-bold mb-4 fade-up">{{ $service->title }}</h1>

                @if($service->description)
                <p class="lead text-muted-custom mb-4 fade-up">{{ $service->description }}</p>
                @endif

                <article class="service-detail-body fade-up">
                    {!! $service->body !!}
                </article>

                <!-- CTA -->
                <div class="mt-5 p-4 bg-soft-primary rounded-4 fade-up">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                        <div>
                            <h3 class="h5 fw-bold mb-1">Bu alanda destek almak ister misiniz?</h3>
                            <p class="text-muted-custom mb-0 small">İlk görüşme için hemen randevu alabilirsiniz.</p>
                        </div>
                        <a href="{{ url('/iletisim') }}"
                           class="btn btn-primary px-4 flex-shrink-0">
                            <i class="bi bi-calendar-check me-1" aria-hidden="true"></i> Randevu Al
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sağ: Diğer Hizmetler -->
            <aside class="col-lg-4">
                <div class="sidebar-card">
                    <h3>
                        <i class="bi bi-grid" aria-hidden="true"></i>
                        Diğer Hizmetler
                    </h3>
                    <div class="d-flex flex-column gap-1">
                        @foreach($otherServices as $other)
                        <a href="{{ route('services.detail', $other->slug) }}" class="other-service-item">
                            <div class="icon-sm" aria-hidden="true">
                                @if($other->icon)
                                    <i class="bi bi-{{ str_replace('heroicon-o-', '', $other->icon) }}"></i>
                                @else
                                    <i class="bi bi-bookmark"></i>
                                @endif
                            </div>
                            <span>{{ $other->title }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
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

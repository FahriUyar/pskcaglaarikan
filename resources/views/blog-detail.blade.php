@extends('layouts.app')

@php
    $title = $post->meta_title ?? $post->title;
    $description = $post->meta_description ?? Str::limit($post->excerpt ?? strip_tags($post->body), 150);
    $ogImage = $post->cover_image ? Storage::url($post->cover_image) : null;
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero pb-0" aria-labelledby="blog-title">
    <div class="container position-relative">
        @if($post->category)
            <span class="badge bg-primary px-3 py-2 shadow-sm mb-3">{{ $post->category->name }}</span>
        @endif
        <h1 id="blog-title" class="display-5 fw-bold mb-4">{{ $post->title }}</h1>
        
        <div class="d-flex align-items-center text-muted-custom mb-5">
            <div class="d-flex align-items-center me-4">
                <i class="bi bi-calendar3 me-2" aria-hidden="true"></i>
                <time datetime="{{ $post->published_at->toIso8601String() }}">
                    {{ $post->published_at->format('d.m.Y') }}
                </time>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle me-2" aria-hidden="true"></i>
                <span>Psikolog Çağla Arıkan</span>
            </div>
        </div>

        @if($post->cover_image)
            <div class="blog-cover-wrap rounded-4 overflow-hidden shadow-sm mb-5">
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
            </div>
        @endif
    </div>
</section>

<!-- Blog İçerik -->
<section class="section-padding pt-0 pb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="blog-content prose">
                    {!! $post->body !!}
                </article>

                <!-- Paylaşım -->
                <div class="d-flex align-items-center justify-content-between mt-5 pt-4 border-top">
                    <span class="fw-medium">Bu yazıyı paylaş:</span>
                    <div class="d-flex gap-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" aria-label="Twitter'da Paylaş">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" aria-label="Facebook'ta Paylaş">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" aria-label="WhatsApp'ta Paylaş">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Diğer Yazılar -->
@if($relatedPosts->count() > 0)
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">İlginizi Çekebilir</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($relatedPosts as $relatedPost)
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 overflow-hidden fade-up">
                    <a href="{{ url('/blog/' . $relatedPost->slug) }}" class="text-decoration-none" aria-label="{{ $relatedPost->title }} yazısını oku">
                        @if($relatedPost->cover_image)
                            <img src="{{ Storage::url($relatedPost->cover_image) }}" class="card-img-top" alt="{{ $relatedPost->title }}" loading="lazy" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="bi bi-journal-text text-muted" style="font-size: 3rem;" aria-hidden="true"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body p-4 d-flex flex-column">
                        <h3 class="h6 card-title fw-bold mb-3">
                            <a href="{{ url('/blog/' . $relatedPost->slug) }}" class="text-decoration-none" style="color: var(--bs-heading-color);">
                                {{ $relatedPost->title }}
                            </a>
                        </h3>
                        <div class="d-flex align-items-center text-muted small mt-auto">
                            <time datetime="{{ $relatedPost->published_at->toIso8601String() }}">
                                {{ $relatedPost->published_at->format('d.m.Y') }}
                            </time>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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

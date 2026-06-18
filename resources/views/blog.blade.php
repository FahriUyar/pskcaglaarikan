@extends('layouts.app')

@php
$title = 'Blog - Psikoloji Yazıları';
$description = 'Psikolog Çağla Arıkan\'ın kaleme aldığı psikoloji, ruh sağlığı ve farkındalık üzerine güncel blog yazıları.';
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero" aria-labelledby="blog-heading">
    <div class="container position-relative">
        <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">Blog</span>
        <h1 id="blog-heading">Psikoloji Yazıları</h1>
        <p class="text-muted-custom">
            Ruh sağlığı, farkındalık ve psikoloji üzerine bilimsel ve güncel makaleler.
        </p>
    </div>
</section>

<!-- Blog Grid -->
<section class="section-padding p-4" aria-label="Blog listesi">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($posts as $post)
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 overflow-hidden fade-up">
                    <a href="{{ url('/blog/' . $post->slug) }}" class="text-decoration-none" aria-label="{{ $post->title }} yazısını oku">
                        @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy" style="height: 220px; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;" aria-hidden="true"></i>
                        </div>
                        @endif
                    </a>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            @if($post->category)
                            <span class="badge bg-secondary">{{ $post->category->name }}</span>
                            @endif
                        </div>
                        <h2 class="h5 card-title fw-bold mb-3">
                            <a href="{{ url('/blog/' . $post->slug) }}" class="text-decoration-none" style="color: var(--bs-heading-color);">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="card-text text-muted-custom small mb-4 flex-grow-1">
                            {{ Str::limit($post->excerpt ?? strip_tags($post->body), 120) }}
                        </p>
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar3 me-2" aria-hidden="true"></i>
                                <time datetime="{{ $post->published_at->toIso8601String() }}">
                                    {{ $post->published_at->format('d.m.Y') }}
                                </time>
                            </div>
                            <a href="{{ url('/blog/' . $post->slug) }}" class="btn btn-sm btn-link text-primary text-decoration-none p-0 fw-medium">
                                Devamını Oku <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted-custom">
                    <i class="bi bi-pencil-square fs-1 d-block mb-3" aria-hidden="true"></i>
                    <p>Henüz yayınlanmış bir yazı bulunmuyor.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $posts->links() }}
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
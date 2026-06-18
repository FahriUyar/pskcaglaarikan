@extends('layouts.app')

@php
$title = 'İletişim';
$description = 'Psikolog Çağla Arıkan ile iletişime geçin. Randevu ve danışmanlık talepleriniz için form doldurun.';
@endphp

@section('content')

<!-- Sayfa Hero -->
<section class="page-hero" aria-labelledby="contact-heading">
    <div class="container position-relative">
        <span class="badge bg-white text-primary px-3 py-2 shadow-sm mb-3">İletişim</span>
        <h1 id="contact-heading">{{ $contactTitle }}</h1>
        @if($contactDescription)
        <p class="text-muted-custom">{{ $contactDescription }}</p>
        @endif
    </div>
</section>

<!-- İletişim Bilgileri Kartları -->
<section class="section-padding pt-4 pb-4" aria-label="İletişim bilgileri">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @if($phone)
            <div class="col-lg-3 col-md-6">
                <div class="contact-info-card fade-up delay-1">
                    <div class="info-icon" aria-hidden="true">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3>Telefon</h3>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>
                </div>
            </div>
            @endif

            @if($email)
            <div class="col-lg-3 col-md-6">
                <div class="contact-info-card fade-up delay-2">
                    <div class="info-icon" aria-hidden="true">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h3>E-posta</h3>
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </div>
            </div>
            @endif

            @if($whatsapp)
            <div class="col-lg-3 col-md-6">
                <div class="contact-info-card fade-up delay-3">
                    <div class="info-icon" aria-hidden="true">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <h3>WhatsApp</h3>
                    <a href="{{ $whatsapp }}" title="WhatsApp ile Ulaşın"
                        target="_blank" rel="noopener noreferrer">Mesaj Gönder</a>
                </div>
            </div>
            @endif

            @if($address)
            <div class="col-lg-3 col-md-6">
                <div class="contact-info-card fade-up delay-4">
                    <div class="info-icon" aria-hidden="true">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3>Adres</h3>
                    <p class="mb-0">{{ $address }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Harita (Tam Genişlik) -->
@if($mapEmbed)
<section class="map-fullwidth fade-up pb-5" aria-label="Konum haritası">
    <div class="container-fluid px-0">
        <div style="width: 100%; height: 450px; position: relative;">
            {!! str_replace('<iframe ', ' <iframe style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;" ', $mapEmbed) !!}
        </div>
    </div>
</section>
@endif

<!-- İletişim Formu -->
<section class="section-padding pt-0" aria-label="İletişim formu">
    <div class="container">
        <div class="row g-5">

            <!-- Form -->
            <div class="col-lg-8 mx-auto">
                <div class="contact-form-card fade-up">
                    <h2 class="h4 fw-bold mb-1">Bize Mesaj Gönderin</h2>
                    <p class="text-muted-custom mb-4">Aşağıdaki formu doldurarak bize ulaşabilirsiniz.</p>

                    <!-- Başarı Mesajı -->
                    @if(session(' success'))
                <div class="alert-success-custom d-flex align-items-center gap-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4" aria-hidden="true"></i>
                <span>{{ session('success') }}</span>
        </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" novalidate id="contact-form">
            @csrf

            <div class="row g-3">
                <!-- İsim -->
                <div class="col-md-6">
                    <label for="contact-name" class="form-label">
                        Ad Soyad <span class="required-star" aria-hidden="true">*</span>
                    </label>
                    <input type="text"
                        id="contact-name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        aria-describedby="name-error"
                        placeholder="Adınız Soyadınız">
                    @error('name')
                    <div class="invalid-feedback" id="name-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <!-- E-posta -->
                <div class="col-md-6">
                    <label for="contact-email" class="form-label">
                        E-posta <span class="required-star" aria-hidden="true">*</span>
                    </label>
                    <input type="email"
                        id="contact-email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        inputmode="email"
                        aria-describedby="email-error"
                        placeholder="ornek@email.com">
                    @error('email')
                    <div class="invalid-feedback" id="email-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telefon (opsiyonel) -->
                <div class="col-12">
                    <label for="contact-phone" class="form-label">
                        Telefon <span class="text-muted-custom small">(opsiyonel)</span>
                    </label>
                    <input type="tel"
                        id="contact-phone"
                        name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        inputmode="tel"
                        aria-describedby="phone-error"
                        placeholder="0(5XX) XXX XX XX">
                    @error('phone')
                    <div class="invalid-feedback" id="phone-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mesaj -->
                <div class="col-12">
                    <label for="contact-message" class="form-label">
                        Mesajınız <span class="required-star" aria-hidden="true">*</span>
                    </label>
                    <textarea id="contact-message"
                        name="message"
                        rows="5"
                        class="form-control @error('message') is-invalid @enderror"
                        required
                        aria-describedby="message-error"
                        placeholder="Mesajınızı buraya yazın...">{{ old('message') }}</textarea>
                    @error('message')
                    <div class="invalid-feedback" id="message-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gönder -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg w-100" id="contact-submit-btn">
                        <i class="bi bi-send me-2" aria-hidden="true"></i> Mesaj Gönder
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>

    </div>
    </div>
</section>

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
    });
</script>
@endpush
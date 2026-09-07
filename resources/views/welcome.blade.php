@extends('layouts.app')

@section('content')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%);
    }
    .card-location-hover {
        transition: all 0.25s ease-in-out;
        border: 1px solid #e2e8f0 !important;
    }
    .card-location-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.15) !important;
        border-color: #10b981 !important;
    }
    .cta-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #065f46 100%);
    }

    /* Style Tombol Panah Kiri-Kanan Melayang */
    .btn-slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 46px;
        height: 46px;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        color: #0f172a;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .btn-slider-nav:hover {
        background-color: #059669;
        color: #ffffff;
        border-color: #059669;
        transform: translateY(-50%) scale(1.1);
    }
    .btn-slider-prev {
        left: -20px;
    }
    .btn-slider-next {
        right: -20px;
    }

    /* Kustomisasi Badge Tipe Gender */
    .badge-gender-putra {
        background-color: #2563eb !important;
        color: #ffffff;
    }
    .badge-gender-putri {
        background-color: #ec4899 !important;
        color: #ffffff;
    }
    .badge-gender-campur {
        background-color: #8b5cf6 !important;
        color: #ffffff;
    }
</style>

<!-- Hero Section -->
<section class="hero-gradient text-white py-5 text-center position-relative">
    <div class="container py-5">
        <span class="badge px-3 py-2 rounded-pill mb-3 fw-semibold border border-success border-opacity-20" style="background-color: rgba(16, 185, 129, 0.15); color: #34d399;">
            <i class="bi bi-house-check me-1"></i> Platform Pencarian & Sewa Kos Online
        </span>

        <h1 class="display-3 fw-bold mb-3">Huni tempat yang cocok buat kamu.</h1>
        <p class="lead mb-0 mx-auto" style="max-width: 650px; color: #cbd5e1;">
            <strong>HUNI</strong> membantu langkahmu menemukan tempat tinggal impian secara transparan, mudah, dan terhubung langsung dengan pengelola kos.
        </p>
    </div>
</section>

<!-- Section Kos Populer / Rekomendasi (Tunggal) -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Rekomendasi Kos Pilihan</h4>
                <p class="text-muted small mb-0">Ragam pilihan tempat tinggal terfavorit di lokasi-lokasi strategis.</p>
            </div>
            <a href="/kos" class="btn btn-sm btn-outline-success fw-bold px-3 py-2 rounded-3">Lihat Semua Kos <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        @if($properties->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">Belum ada kos terverifikasi yang tersedia saat ini.</p>
            </div>
        @else
            <!-- Carousel Container -->
            <div id="popularKosCarousel" class="carousel slide position-relative px-md-3" data-bs-ride="false">
                
                @if($properties->count() > 3)
                    <button class="btn-slider-nav btn-slider-prev" type="button" id="btnPrevSlide">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </button>
                    
                    <button class="btn-slider-nav btn-slider-next" type="button" id="btnNextSlide">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </button>
                @endif

                <div class="carousel-inner overflow-hidden">
                    @foreach($properties->take(6)->chunk(3) as $chunkIndex => $propertyChunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach($propertyChunk as $property)
                                    @php
                                        $primaryPhoto = $property->photos->where('is_primary', true)->first() ?? $property->photos->first();
                                        $photoUrl = ($primaryPhoto && $primaryPhoto->image_path) 
                                            ? asset('storage/' . $primaryPhoto->image_path) 
                                            : 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80';
                                        $minPrice = $property->rooms->min('price');

                                        $gender = strtolower($property->gender_type);
                                        $badgeClass = 'badge-gender-campur';
                                        if ($gender === 'putra') {
                                            $badgeClass = 'badge-gender-putra';
                                        } elseif ($gender === 'putri') {
                                            $badgeClass = 'badge-gender-putri';
                                        }
                                    @endphp

                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                                            <div class="position-relative">
                                                <img src="{{ $photoUrl }}" class="card-img-top" alt="{{ $property->name }}" style="height: 210px; object-fit: cover;">
                                                
                                                <span class="badge {{ $badgeClass }} position-absolute top-0 start-0 m-3 text-uppercase px-2.5 py-1.5 fs-7 shadow-sm">
                                                    {{ ucfirst($property->gender_type) }}
                                                </span>
                                            </div>
                                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                                <div>
                                                    <h5 class="fw-bold mb-1 text-dark text-truncate">{{ $property->name }}</h5>
                                                    <p class="text-muted small mb-3"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $property->district }}, {{ $property->city }}</p>
                                                </div>
                                                
                                                <div>
                                                    <div class="fw-bold text-success fs-5 mb-3">
                                                        @if($minPrice)
                                                            Rp {{ number_format($minPrice, 0, ',', '.') }} <span class="fs-6 text-muted fw-normal">/ bulan</span>
                                                        @else
                                                            <span class="text-muted fs-6">Harga belum diatur</span>
                                                        @endif
                                                    </div>

                                                    <a href="/kos/{{ $property->slug }}" class="btn btn-outline-success w-100 btn-sm fw-bold py-2 rounded-3">Lihat Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Cari Berdasarkan Lokasi Populer di Pulau Jawa -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="mb-4 text-center text-md-start">
            <h4 class="fw-bold text-dark mb-1">Eksplorasi Area Favorit</h4>
            <p class="text-muted small mb-0">Temukan hunian di sekitar pusat aktivitas dan universitas populer di Pulau Jawa.</p>
        </div>
        <div class="row g-3">
            <!-- Jakarta -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Jakarta" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/jakarta.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Jakarta" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Jakarta</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Bandung -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Bandung" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/bandung.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Bandung" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Bandung</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Yogyakarta -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Yogyakarta" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/yogyakarta.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Yogyakarta" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Yogyakarta</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Surabaya -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Surabaya" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/surabaya.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Surabaya" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Surabaya</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Malang -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Malang" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/malang.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Malang" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Malang</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Semarang -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/kos?search=Semarang" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-location-hover h-100 bg-dark text-white position-relative" style="min-height: 160px;">
                        <img src="{{ asset('images/semarang.jpg') }}" class="card-img h-100 w-100 position-absolute top-0 start-0" alt="Semarang" style="object-fit: cover; opacity: 0.7;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 position-relative z-1" style="background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.1) 100%);">
                            <h6 class="fw-bold text-white mb-0">Semarang</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Banner Pasang Kos untuk Pemilik (Warna Gradien + Gambar Lokal) -->
<section class="py-5 cta-gradient text-white overflow-hidden">
    <div class="container py-2">
        <div class="row align-items-center">
            <!-- Sisi Kiri: Teks & Tombol CTA -->
            <div class="col-lg-7 col-md-6 mb-4 mb-md-0 text-center text-md-start">
                <h3 class="fw-bold mb-2">Punya Usaha Kos-Kosan?</h3>
                <p class="mb-4 fs-6" style="color: #cbd5e1;">
                    Gunakan HUNI untuk mempromosikan kos milikmu secara gratis dan dapatkan pencari kos lebih cepat.
                </p>
                <a href="/register" class="btn btn-huni btn-lg px-4 fs-6 shadow rounded-3">
                    <i class="bi bi-plus-circle me-1"></i> Pasang Kos Sekarang
                </a>
            </div>

            <!-- Sisi Kanan: Gambar Foto Pilihanmu (Curved) -->
            <div class="col-lg-5 col-md-6 d-none d-md-block position-relative" style="min-height: 240px;">
                <div class="h-100 w-100 overflow-hidden shadow-lg" style="border-top-left-radius: 120px; border-bottom-left-radius: 120px;">
                    <img src="{{ asset('images/banner-owner.jpeg') }}" 
                         alt="Diskusi Pemilik Kos HUNI" 
                         class="w-100 h-100" 
                         style="object-fit: cover; object-position: center;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section SEO / Ringkasan Platform HUNI -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container text-center" style="max-width: 850px;">
        <h4 class="fw-bold text-dark mb-3">HUNI - Layanan Pencarian & Pengelolaan Sewa Tempat Tinggal</h4>
        <p class="text-muted medium lh-lg mb-0">
            HUNI adalah platform digital yang dirancang untuk mempermudah pencarian hunian kos serta pengelolaan sewa tempat tinggal secara modern. Kami menyajikan rincian lokasi, harga transparan, serta akses komunikasi langsung ke pemilik kos agar proses pencarian hunian impianmu menjadi lebih singkat dan efisien.
        </p>
    </div>
</section>

<!-- Footer Platform HUNI -->
<footer class="bg-white border-top py-5 text-dark">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h3 class="fw-bold text-success mb-3" style="letter-spacing: -1px;">HUNI<span class="text-dark">.</span></h3>
                <p class="text-muted small mb-4">
                    Temukan tempat tinggal yang cocok dan nyaman bersama HUNI. Solusi cari kos tanpa ribet.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-dark btn-sm rounded-3 px-3 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-google-play fs-6"></i>
                        <div class="text-start lh-1">
                            <span class="d-block opacity-75" style="font-size: 8px;">DAPATKAN DI</span>
                            <span class="fw-bold small">Google Play</span>
                        </div>
                    </a>
                    <a href="#" class="btn btn-dark btn-sm rounded-3 px-3 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-apple fs-6"></i>
                        <div class="text-start lh-1">
                            <span class="d-block opacity-75" style="font-size: 8px;">UNDUH DI</span>
                            <span class="fw-bold small">App Store</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-dark text-uppercase mb-3">HUNI</h6>
                <ul class="list-unstyled small text-muted lh-lg mb-0">
                    {{-- Tautan aktif ke halaman Tentang Kami --}}
                    <li><a href="/tentang-kami" class="text-decoration-none text-muted">Tentang Kami</a></li>
                    <li><a href="/register" class="text-decoration-none text-muted">Iklankan Properti Kos</a></li>
                    <li><a href="https: " target="_blank" class="text-decoration-none text-muted">Pusat Bantuan</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-dark text-uppercase mb-3">KEBIJAKAN</h6>
                <ul class="list-unstyled small text-muted lh-lg mb-0">
                    <li><a href="/kebijakan-privasi" class="text-decoration-none text-muted">Kebijakan Privasi</a></li>
                    <li><a href="/syarat-dan-ketentuan" class="text-decoration-none text-muted">Syarat dan Ketentuan</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-dark text-uppercase mb-3">HUBUNGI KAMI</h6>
                <ul class="list-unstyled small text-muted mb-3 lh-lg">
                    <li><i class="bi bi-envelope me-2 text-success"></i>suryopambengkas@students.amikom.ac.id</li>
                    <li><i class="bi bi-whatsapp me-2 text-success"></i>+62 813-2511-1171</li>
                </ul>
                <div class="d-flex gap-3 fs-5 text-secondary">
                    <a href="#" class="text-secondary"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Script Carousel Slider -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var prevBtn = document.getElementById('btnPrevSlide');
        var nextBtn = document.getElementById('btnNextSlide');

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function () {
                var items = document.querySelectorAll('#popularKosCarousel .carousel-item');
                items.forEach(function(item) {
                    item.classList.toggle('active');
                });
            });

            nextBtn.addEventListener('click', function () {
                var items = document.querySelectorAll('#popularKosCarousel .carousel-item');
                items.forEach(function(item) {
                    item.classList.toggle('active');
                });
            });
        }
    });
</script>
@endsection
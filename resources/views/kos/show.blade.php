@extends('layouts.app')

@section('content')
<!-- Leaflet CSS & JS untuk Peta Interaktif -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item"><a href="/kos" class="text-decoration-none text-muted">Cari Kos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $property->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Kolom Kiri: Galeri Foto, Informasi Utama, Peta, & Ulasan -->
        <div class="col-lg-8">
            <!-- Galeri Foto Utama -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4 bg-white">
                @if($property->photos->isNotEmpty())
                    @php
                        $firstPhoto = $property->photos->first();
                    @endphp
                    <div class="position-relative">
                        <!-- Display Foto Utama -->
                        <img id="mainDisplayImage" 
                             src="{{ asset('storage/' . $firstPhoto->image_path) }}" 
                             class="d-block w-100" 
                             style="height: 420px; object-fit: cover;" 
                             alt="{{ $property->name }}">

                        <!-- Tombol Panah Kiri-Kanan Murni JS -->
                        @if($property->photos->count() > 1)
                            <button type="button" class="btn btn-dark bg-opacity-50 position-absolute top-50 start-0 translate-middle-y ms-2 rounded-circle p-2 border-0" onclick="prevImage()">
                                <i class="bi bi-chevron-left fs-4 text-white"></i>
                            </button>
                            <button type="button" class="btn btn-dark bg-opacity-50 position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle p-2 border-0" onclick="nextImage()">
                                <i class="bi bi-chevron-right fs-4 text-white"></i>
                            </button>
                        @endif
                    </div>

                    <!-- Thumbnail Kecil di Bawah Display Utama -->
                    @if($property->photos->count() > 1)
                        <div class="p-3 border-top d-flex gap-2 overflow-auto bg-light">
                            @foreach($property->photos as $index => $photo)
                                <img src="{{ asset('storage/' . $photo->image_path) }}" 
                                     class="rounded border thumb-item {{ $index === 0 ? 'border-success border-3' : '' }}" 
                                     style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;" 
                                     onclick="selectImage({{ $index }}, '{{ asset('storage/' . $photo->image_path) }}')"
                                     alt="Thumbnail {{ $index + 1 }}">
                            @endforeach
                        </div>
                    @endif
                @else
                    <img src="https://via.placeholder.com/800x420?text=Foto+Belum+Tersedia" class="img-fluid w-100" style="height: 420px; object-fit: cover;" alt="No Image">
                @endif
            </div>

            <!-- Detail Informasi Kos -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-danger text-uppercase px-2 py-1">{{ $property->gender_type }}</span>
                    <span class="text-muted small"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $property->district }}, {{ $property->city }}</span>
                </div>
                <h3 class="fw-bold text-dark mb-3">{{ $property->name }}</h3>
                <p class="text-muted">{{ $property->address }}</p>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Deskripsi Kos</h5>
                <p class="text-secondary" style="white-space: pre-line;">{{ $property->description }}</p>

                @if($property->rules)
                    <h5 class="fw-bold mb-2 mt-4">Peraturan Kos</h5>
                    <p class="text-secondary" style="white-space: pre-line;">{{ $property->rules }}</p>
                @endif
            </div>

            <!-- FITUR 1: Peta Interaktif Lokasi Kos + Tombol Google Maps -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Lokasi Kos</h5>
                    
                    @php
                        $lat = $property->latitude ?? -7.759;
                        $lng = $property->longitude ?? 110.408;
                        $gmapsUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
                    @endphp

                    <a href="{{ $gmapsUrl }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm">
                        <i class="bi bi-map-fill"></i>
                        <span>Buka di Google Maps</span>
                    </a>
                </div>

                <p class="text-muted small mb-3">{{ $property->address }}</p>

                <!-- Div Wadah Peta Leaflet -->
                <div id="map" style="height: 350px; border-radius: 12px; z-index: 1;" class="shadow-sm"></div>
            </div>

            <!-- FITUR 2: Sistem Review & Rating Komunitas -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                @php
                    $reviews = $property->reviews ?? collect();
                    $avgRating = $reviews->avg('rating') ? round($reviews->avg('rating'), 1) : null;
                @endphp

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Ulasan Penyewa</h5>
                    @if($avgRating)
                        <div class="d-flex align-items-center gap-1 bg-light px-3 py-1.5 rounded-pill border">
                            <i class="bi bi-star-fill text-warning fs-6"></i>
                            <span class="fw-bold text-dark">{{ $avgRating }}</span>
                            <span class="text-muted small">({{ $reviews->count() }} Ulasan)</span>
                        </div>
                    @endif
                </div>

                @if($reviews->isEmpty())
                    <div class="text-center py-4 text-muted bg-light rounded-3">
                        <i class="bi bi-chat-square-text fs-2 d-block mb-2 text-secondary"></i>
                        <p class="mb-0 small">Belum ada ulasan untuk kos ini. Jadilah penyewa pertama yang memberikan ulasan!</p>
                    </div>
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach($reviews as $review)
                            <div class="p-3 border rounded-3 bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-huni-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $review->user->name ?? 'Penyewa' }}</div>
                                            <div class="text-muted style-tiny" style="font-size: 11px;">{{ $review->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-secondary small mb-0">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- List Kamar Tersedia -->
            <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                <h5 class="fw-bold mb-3">Pilihan Kamar Tersedia</h5>
                @if($property->rooms->isEmpty())
                    <div class="alert alert-warning border-0 small mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i> Saat ini belum ada kamar yang terdaftar untuk kos ini.
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($property->rooms as $room)
                            @php
                                $isBooked = $room->bookings && $room->bookings->where('status', 'approved')->count() > 0;
                            @endphp
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-light d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-0">No. {{ $room->room_number }} (Lantai {{ $room->floor }})</h6>
                                            @if($isBooked)
                                                <span class="badge bg-danger px-2.5 py-1.5">Penuh / Terisi</span>
                                            @else
                                                <span class="badge bg-success px-2.5 py-1.5">Tersedia</span>
                                            @endif
                                        </div>
                                        <p class="text-muted small mb-2">{{ $room->type }}</p>
                                        <div class="fw-bold text-success fs-5 mb-3">
                                            Rp {{ number_format($room->price, 0, ',', '.') }} <span class="fs-6 text-muted font-weight-normal">/ bln</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Tombol Ajukan Sewa / Kamar Penuh -->
                                    @if($isBooked)
                                        <button class="btn btn-secondary btn-sm w-100 fw-bold py-2" disabled>
                                            <i class="bi bi-x-circle me-1"></i> Kamar Terisi
                                        </button>
                                    @else
                                        <a href="/rooms/{{ $room->id }}/book" class="btn btn-huni btn-sm w-100 fw-bold py-2">
                                            <i class="bi bi-calendar-check me-1"></i> Ajukan Sewa
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Card Kontak Pemilik -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-4 sticky-top bg-white" style="top: 90px;">
                <h5 class="fw-bold mb-1">Tertarik dengan Kos Ini?</h5>
                <p class="text-muted small mb-4">Hubungi pemilik kos secara langsung melalui WhatsApp untuk negosiasi atau survei lokasi.</p>

                <div class="p-3 bg-light rounded-3 mb-4 d-flex align-items-center gap-3">
                    <div class="bg-success text-white p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $property->user->name }}</div>
                        <small class="text-muted">Pemilik Kos</small>
                    </div>
                </div>

                @php
                    $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $property->contact_number));
                    $waMessage = rawurlencode("Halo {$property->user->name}, saya tertarik dengan kos {$property->name} yang ada di HUNI.");
                @endphp

                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="btn btn-success w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 mb-2">
                    <i class="bi bi-whatsapp fs-5"></i>
                    <span>Hubungi via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Murni untuk Switch Galeri Foto & Peta Leaflet -->
<script>
    // Galeri Foto
    var photoList = [
        @foreach($property->photos as $photo)
            "{{ asset('storage/' . $photo->image_path) }}",
        @endforeach
    ];
    var currentIndex = 0;

    function updateDisplay() {
        var mainImg = document.getElementById('mainDisplayImage');
        if (mainImg && photoList.length > 0) {
            mainImg.src = photoList[currentIndex];
        }

        var thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(function(thumb, idx) {
            if (idx === currentIndex) {
                thumb.classList.add('border-success', 'border-3');
            } else {
                thumb.classList.remove('border-success', 'border-3');
            }
        });
    }

    function selectImage(index, url) {
        currentIndex = index;
        updateDisplay();
    }

    function prevImage() {
        if (photoList.length <= 1) return;
        currentIndex = (currentIndex === 0) ? photoList.length - 1 : currentIndex - 1;
        updateDisplay();
    }

    function nextImage() {
        if (photoList.length <= 1) return;
        currentIndex = (currentIndex === photoList.length - 1) ? 0 : currentIndex + 1;
        updateDisplay();
    }

    // Inisialisasi Peta Leaflet.js
    document.addEventListener("DOMContentLoaded", function () {
        var lat = {{ $property->latitude ?? -7.759 }};
        var lng = {{ $property->longitude ?? 110.408 }};

        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>{{ $property->name }}</b><br>{{ $property->address }}')
            .openPopup();
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Tombol Kembali Ber-border -->
    <div class="mb-3">
        <a href="/" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-1.5">
            &larr; Kembali ke Beranda
        </a>
    </div>

    <!-- Title & Search Bar -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <h4 class="fw-bold text-dark mb-3">Cari Tempat Kos Idealmu</h4>
        <form action="/kos" method="GET">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari lokasi, kota, atau nama kos..." value="{{ request('search') ?? request('location') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="gender_type" class="form-select bg-light">
                        <option value="">Semua Tipe Kos</option>
                        <option value="putra" {{ request('gender_type') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ request('gender_type') == 'putri' ? 'selected' : '' }}>Putri</option>
                        <option value="campur" {{ request('gender_type') == 'campur' ? 'selected' : '' }}>Campur</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="max_price" class="form-select bg-light">
                        <option value="">Semua Harga</option>
                        <option value="800000" {{ request('max_price') == '800000' ? 'selected' : '' }}>&lt; Rp 800rb / bln</option>
                        <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>&lt; Rp 1 Juta / bln</option>
                        <option value="1500000" {{ request('max_price') == '1500000' ? 'selected' : '' }}>&lt; Rp 1,5 Juta / bln</option>
                        <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>&lt; Rp 2 Juta / bln</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-huni w-100 fw-bold">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Grid Results -->
    <div class="row g-4">
        @forelse($properties as $property)
            @php
                // Ambil foto utama atau foto pertama
                $primaryPhoto = $property->photos->where('is_primary', true)->first() ?? $property->photos->first();
                
                // Jika tidak ada foto, gunakan gambar placeholder kos yang bagus
                $photoUrl = $primaryPhoto 
                    ? asset('storage/' . $primaryPhoto->image_path) 
                    : 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80';
                    
                $minPrice = $property->rooms->min('price');
            @endphp

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 bg-white">
                    <div class="position-relative">
                        <img src="{{ $photoUrl }}" class="card-img-top" alt="{{ $property->name }}" style="height: 220px; object-fit: cover;">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 text-uppercase px-2.5 py-1.5 fs-7">
                            {{ $property->gender_type }}
                        </span>
                    </div>
                    <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1 text-truncate">{{ $property->name }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt text-danger me-1"></i>{{ $property->district }}, {{ $property->city }}
                            </p>
                        </div>
                        
                        <div>
                            <div class="fw-bold text-success fs-5 mb-3">
                                @if($minPrice)
                                    Rp {{ number_format($minPrice, 0, ',', '.') }} <span class="fs-6 text-muted fw-normal">/ bln</span>
                                @else
                                    <span class="text-muted fs-6">Harga belum diatur</span>
                                @endif
                            </div>

                            <a href="/kos/{{ $property->slug }}" class="btn btn-outline-success w-100 btn-sm fw-bold py-2">Lihat Detail Kos</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="bg-light d-inline-flex p-4 rounded-circle text-muted mb-3">
                    <i class="bi bi-search fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark">Kos Tidak Ditemukan</h5>
                <p class="text-muted small">Coba ubah kata kunci atau hapus filter pencarian Anda.</p>
                <a href="/kos" class="btn btn-sm btn-outline-secondary">Reset Pencarian</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-5">
        {{ $properties->links() }}
    </div>
</div>
@endsection
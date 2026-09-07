@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Langganan Publikasi Kos</h3>
            <p class="text-muted small mb-0">Kelola status aktif tayang kos Anda di platform HUNI (Rp 50.000 / bulan).</p>
        </div>
        <!-- Tombol Kembali Ke Dashboard -->
        <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($properties->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white">
            <div class="card-body">
                <div class="bg-light d-inline-flex p-3 rounded-circle text-muted mb-3">
                    <i class="bi bi-house-add fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark">Belum Ada Properti Kos</h5>
                <p class="text-muted small mb-3">Anda belum memiliki kos yang terdaftar. Tambahkan kos terlebih dahulu.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm px-4 py-2 fw-semibold rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <a href="/owner/properties/create" class="btn btn-huni btn-sm px-4 py-2 fw-bold rounded-3">
                        Tambah Kos Baru
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($properties as $property)
                @php
                    $activeSub = $property->subscriptions->where('status', 'paid')->where('ends_at', '>=', now())->first();
                    $isSubscribed = !is_null($activeSub);
                @endphp
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $property->name }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-geo-alt text-danger me-1"></i>{{ $property->district }}, {{ $property->city }}
                                </p>
                            </div>
                            <div>
                                @if($isSubscribed)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Aktif Tayang
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Belum Berlangganan / Kadaluwarsa
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-2">

                        <div class="small mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Biaya Langganan:</span>
                                <span class="fw-bold text-dark">Rp 50.000 / Bulan</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Mulai Berlangganan:</span>
                                <span class="fw-bold text-dark">
                                    {{ $isSubscribed ? \Carbon\Carbon::parse($activeSub->starts_at)->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Masa Aktif s/d:</span>
                                <span class="fw-bold {{ $isSubscribed ? 'text-success' : 'text-danger' }}">
                                    {{ $isSubscribed ? \Carbon\Carbon::parse($activeSub->ends_at)->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Sisa Masa Tayang:</span>
                                <span class="fw-bold text-dark">
                                    {{ $isSubscribed ? max(0, (int) now()->diffInDays(\Carbon\Carbon::parse($activeSub->ends_at), false)) . ' Hari Lagi' : '0 Hari' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Form Bayar -->
                        <div class="mt-auto pt-2">
                            <form action="/owner/subscriptions/{{ $property->id }}/pay" method="POST" onsubmit="return confirm('Konfirmasi pembayaran langganan Rp 50.000 untuk 1 bulan tayang?')">
                                @csrf
                                <button type="submit" class="btn btn-huni w-100 fw-bold py-2 rounded-3 shadow-sm">
                                    <i class="bi bi-credit-card-fill me-1"></i>
                                    {{ $isSubscribed ? 'Perpanjang Langganan (Rp 50.000)' : 'Bayar & Aktifkan Kos (Rp 50.000)' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
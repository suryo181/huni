@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: calc(100vh - 180px);">
    
    <!-- Tombol Kembali Ber-border -->
    <div class="mb-3">
        <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-1.5">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <!-- Header Navigasi -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Kelola Kamar - {{ $property->name }}</h3>
            <p class="text-muted small mb-0">Atur daftar unit kamar, tipe, dan harga sewa per bulan.</p>
        </div>
        <div>
            <a href="/owner/properties/{{ $property->id }}/rooms/create" class="btn btn-huni px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Kamar Baru</span>
            </a>
        </div>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Daftar Kamar (Grid Layout) -->
    @if($rooms->isEmpty())
        <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
            <div class="bg-light d-inline-flex p-4 rounded-circle text-muted mb-3 mx-auto" style="width: fit-content;">
                <i class="bi bi-door-closed fs-1"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Belum Ada Kamar Terdaftar</h5>
            <p class="text-muted small mx-auto mb-4" style="max-width: 400px;">
                Anda belum menambahkan unit kamar untuk kos ini. Silakan klik tombol di bawah untuk menambah unit kamar pertama.
            </p>
            <div>
                <a href="/owner/properties/{{ $property->id }}/rooms/create" class="btn btn-huni px-4 py-2 fw-semibold">
                    + Tambah Kamar
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 h-100 bg-white overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Header Card: Nomor & Badge Tipe -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0">No. {{ $room->room_number }}</h5>
                                        <small class="text-muted">Lantai {{ $room->floor ?? '1' }}</small>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill text-capitalize">
                                        {{ $room->type ?? 'Kamar' }}
                                    </span>
                                </div>

                                <hr class="my-3 text-black-50">

                                <!-- Harga -->
                                <div class="mb-3">
                                    <span class="text-muted style-tiny d-block" style="font-size: 12px;">Harga Sewa / Bulan</span>
                                    <span class="fs-4 fw-bold text-success">
                                        Rp {{ number_format($room->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tombol Aksi Kelola -->
                            <div class="d-flex gap-2 pt-2 border-top">
                                <a href="/owner/rooms/{{ $room->id }}/edit" class="btn btn-sm btn-outline-secondary w-100 fw-semibold">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="/owner/rooms/{{ $room->id }}" method="POST" class="w-100" onsubmit="return confirm('Hapus kamar nomor {{ $room->room_number }} ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-semibold">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
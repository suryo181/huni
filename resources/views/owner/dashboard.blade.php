@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: calc(100vh - 180px);">
    <!-- Top Bar Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Dashboard Pemilik</h3>
            <p class="text-muted small mb-0">Kelola unit kos, pemesanan, dan ketersediaan kamar Anda secara efisien.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Tombol Kelola Langganan -->
            <a href="/owner/subscriptions" class="btn btn-warning px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-sm text-dark">
                <i class="bi bi-card-checklist"></i>
                <span>Kelola Langganan (Rp 50k)</span>
            </a>
            <a href="/owner/bookings" class="btn btn-outline-success px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-sm bg-white">
                <i class="bi bi-journal-check"></i>
                <span>Kelola Pesanan Masuk</span>
            </a>
            <a href="/owner/properties/create" class="btn btn-huni px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Tambah Kos Baru</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $totalRoomsAll = $properties->sum(fn($p) => $p->rooms->count());
        $totalFilledRoomsAll = $properties->sum(function($p) {
            return $p->rooms->filter(function($room) {
                return $room->bookings && $room->bookings->where('status', 'approved')->count() > 0;
            })->count();
        });
        $totalAvailableRoomsAll = max(0, $totalRoomsAll - $totalFilledRoomsAll);
    @endphp

    <!-- Stat Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Properti</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $properties->count() }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Kamar</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalRoomsAll }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                        <i class="bi bi-door-open fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Kamar Kosong</span>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $totalAvailableRoomsAll }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="bi bi-door-open-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Kamar Terisi</span>
                        <h2 class="fw-bold text-danger mt-1 mb-0">{{ $totalFilledRoomsAll }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                        <i class="bi bi-person-fill-lock fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark">Daftar Properti Kos</h5>
            <span class="badge bg-light text-dark border px-2.5 py-1.5 fs-7">{{ $properties->count() }} Unit</span>
        </div>
        <div class="card-body p-0">
            @if($properties->isEmpty())
                <div class="text-center py-5 px-3">
                    <p class="text-muted mb-3">Anda belum memiliki properti kos yang terdaftar.</p>
                    <a href="/owner/properties/create" class="btn btn-sm btn-huni fw-bold">Tambah Kos Pertama</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Nama Properti</th>
                                <th>Lokasi</th>
                                <th>Status Kelengkapan</th>
                                <th>Status Admin</th>
                                <th>Status Langganan</th>
                                <th>Status Kamar</th>
                                <th class="text-end pe-4">Aksi Management</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $property)
                                @php
                                    $filledRooms = $property->rooms->filter(function($room) {
                                        return $room->bookings && $room->bookings->where('status', 'approved')->count() > 0;
                                    })->count();

                                    $totalRooms = $property->rooms->count();
                                    $availableRooms = max(0, $totalRooms - $filledRooms);
                                    $hasPhotos = $property->photos->count() > 0;
                                    $hasRooms = $totalRooms > 0;

                                    // Cek Status Langganan Aktif
                                    $isSubscribed = method_exists($property, 'isSubscribed') ? $property->isSubscribed() : false;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark fs-6">{{ $property->name }}</div>
                                        <small class="text-muted">{{ $property->contact_number }}</small>
                                    </td>
                                    <td>
                                        <div class="text-dark small fw-semibold">
                                            <i class="bi bi-geo-alt text-danger me-1"></i>{{ $property->district }}
                                        </div>
                                        <small class="text-muted">{{ $property->city }}</small>
                                    </td>
                                    <td>
                                        <small class="d-block">
                                            <span class="{{ $hasPhotos ? 'text-success' : 'text-danger fw-bold' }}">
                                                <i class="bi {{ $hasPhotos ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i> {{ $property->photos->count() }} Foto
                                            </span>
                                        </small>
                                        <small class="d-block">
                                            <span class="{{ $hasRooms ? 'text-success' : 'text-danger fw-bold' }}">
                                                <i class="bi {{ $hasRooms ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i> {{ $totalRooms }} Kamar
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        @if($property->status == 'active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                                <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                                            </span>
                                        @elseif($property->status == 'pending_review')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                                            </span>
                                        @elseif($property->status == 'draft')
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1 rounded-pill">
                                                Belum Diajukan
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                                                Ditolak / Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isSubscribed)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill">
                                                <i class="bi bi-patch-check-fill me-1"></i> Aktif (50k/bln)
                                            </span>
                                        @else
                                            <a href="/owner/subscriptions" class="badge bg-warning-subtle text-dark border border-warning-subtle px-2.5 py-1.5 rounded-pill text-decoration-none">
                                                <i class="bi bi-exclamation-circle-fill text-warning me-1"></i> Belum Bayar
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-2">
                                                <i class="bi bi-door-open-fill me-1"></i>{{ $availableRooms }} Kosong
                                            </span>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-2">
                                                <i class="bi bi-person-fill-lock me-1"></i>{{ $filledRooms }} Terisi
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1 align-items-center">
                                            <!-- Kelola Foto -->
                                            <a href="/owner/properties/{{ $property->id }}/photos" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1" title="Kelola Foto">
                                                <i class="bi bi-image"></i> Foto
                                            </a>

                                            <!-- Kelola Kamar -->
                                            <a href="/owner/properties/{{ $property->id }}/rooms" class="btn btn-sm btn-outline-dark fw-semibold d-inline-flex align-items-center gap-1" title="Kelola Kamar">
                                                <i class="bi bi-door-closed"></i> Kamar
                                            </a>

                                            <!-- Edit Kos -->
                                            <a href="/owner/properties/{{ $property->id }}/edit" class="btn btn-sm btn-outline-primary fw-semibold d-inline-flex align-items-center gap-1" title="Edit Detail Kos">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <!-- Hapus Kos -->
                                            <form action="/owner/properties/{{ $property->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kos {{ $property->name }} ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Hapus Kos">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <!-- Tombol Ajukan Verifikasi -->
                                            @if($property->status == 'draft' || $property->status == 'rejected')
                                                @if($hasPhotos && $hasRooms)
                                                    <form action="/owner/properties/{{ $property->id }}/submit" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success fw-bold ms-1">
                                                            Ajukan Verifikasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-secondary ms-1" disabled title="Isi minimal 1 foto dan 1 kamar terlebih dahulu">
                                                        Lengkapi Data
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
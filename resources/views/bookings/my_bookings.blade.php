@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Riwayat Pengajuan Sewa</h3>
            <p class="text-muted small mb-0">Pantau status persetujuan pengajuan kamar kos Anda dari pemilik.</p>
        </div>
        <a href="/kos" class="btn btn-outline-success btn-sm fw-bold">
            <i class="bi bi-search me-1"></i> Cari Kos Lain
        </a>
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

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="card-body p-0">
            @if($bookings->isEmpty())
                <div class="text-center py-5 px-3">
                    <div class="bg-light d-inline-flex p-4 rounded-circle text-muted mb-3">
                        <i class="bi bi-journal-x fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Pengajuan Sewa</h5>
                    <p class="text-muted small mx-auto mb-4" style="max-width: 400px;">
                        Anda belum pernah mengajukan sewa kamar kos. Cari kos impianmu dan ajukan sewa sekarang!
                    </p>
                    <a href="/kos" class="btn btn-huni px-4 py-2">Mulai Cari Kos</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Properti & Kamar</th>
                                <th>Tanggal Mulai</th>
                                <th>Durasi</th>
                                <th>Total Biaya</th>
                                <th>Status Pengajuan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark fs-6">{{ $booking->room->property->name }}</div>
                                        <small class="text-muted">Kamar No. {{ $booking->room->room_number }} ({{ $booking->room->type }})</small>
                                    </td>
                                    <td>
                                        <div class="text-dark small fw-semibold">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $booking->duration_months }} Bulan</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi
                                            </span>
                                        @elseif($booking->status == 'approved')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border px-3 py-1 rounded-pill">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="/kos/{{ $booking->room->property->slug }}" class="btn btn-sm btn-outline-dark px-3 rounded-2">
                                            Lihat Kos
                                        </a>
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
@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <!-- Tombol Kembali Ber-border -->
    <div class="mb-3">
        <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-1.5">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <!-- Header Judul -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-0">Daftar Pengajuan Sewa Masuk</h3>
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

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="card-body p-0">
            @if($bookings->isEmpty())
                <div class="text-center py-5 px-3">
                    <div class="bg-light d-inline-flex p-4 rounded-circle text-muted mb-3">
                        <i class="bi bi-inbox fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Pengajuan Sewa</h5>
                    <p class="text-muted small mx-auto" style="max-width: 400px;">
                        Pengajuan sewa dari calon penyewa untuk unit kos Anda akan muncul di sini.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Data Penyewa</th>
                                <th>Status / Pekerjaan</th>
                                <th>Properti & Kamar</th>
                                <th>Mulai Sewa</th>
                                <th>Durasi</th>
                                <th>Total Biaya</th>
                                <th>Status Sewa</th>
                                <th class="text-end pe-4">Aksi Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                        <div class="small text-muted"><i class="bi bi-whatsapp text-success me-1"></i>{{ $booking->phone_number ?? '-' }}</div>
                                        <small class="text-muted d-block">{{ $booking->user->email }}</small>
                                        @if($booking->notes)
                                            <div class="text-secondary small fst-italic mt-1">
                                                <i class="bi bi-chat-left-text me-1"></i>"{{ $booking->notes }}"
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border mb-1 d-inline-block">{{ $booking->occupation ?? 'Umum' }}</span><br>
                                        <small class="text-muted"><i class="bi bi-gender-ambiguous me-1"></i>{{ $booking->gender ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $booking->property->name ?? $booking->room->property->name ?? '-' }}</div>
                                        <small class="text-muted">Kamar No. {{ $booking->room->room_number ?? '-' }} ({{ $booking->room->type ?? 'Kamar' }})</small>
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
                                                Menunggu Konfirmasi
                                            </span>
                                        @elseif($booking->status == 'approved')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                                Sedang Huni
                                            </span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1 rounded-pill">
                                                Sewa Selesai
                                            </span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1 rounded-pill">
                                                Dibatalkan / Expired
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($booking->status == 'pending')
                                            <div class="d-inline-flex gap-1">
                                                <!-- Form Approve -->
                                                <form action="/owner/bookings/{{ $booking->id }}/status" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-outline-success px-3 fw-semibold">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <!-- Form Reject -->
                                                <form action="/owner/bookings/{{ $booking->id }}/status" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 fw-semibold" onclick="return confirm('Tolak pengajuan sewa ini?')">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($booking->status == 'approved')
                                            @php
                                                $tenantPhone = $booking->phone_number ?? $booking->user->phone ?? '628123456789';
                                                $cleanTenantPhone = preg_replace('/[^0-9]/', '', $tenantPhone);
                                                if(str_starts_with($cleanTenantPhone, '0')) {
                                                    $cleanTenantPhone = '62' . substr($cleanTenantPhone, 1);
                                                }
                                                $waTenantText = rawurlencode("Halo " . $booking->user->name . ", terkait sewa kos Anda di " . ($booking->property->name ?? '') . "...");
                                            @endphp
                                            <div class="d-inline-flex gap-1">
                                                <a href="https://wa.me/{{ $cleanTenantPhone }}?text={{ $waTenantText }}" target="_blank" class="btn btn-sm btn-outline-success fw-semibold" title="Chat WA Penyewa">
                                                    <i class="bi bi-whatsapp"></i> WA
                                                </a>
                                                <!-- Form Selesaikan Sewa -->
                                                <form action="/owner/bookings/{{ $booking->id }}/status" method="POST" onsubmit="return confirm('Apakah penyewa sudah keluar dan sewa dinyatakan selesai?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary fw-semibold">
                                                        Selesaikan Sewa
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">Selesai</span>
                                        @endif
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
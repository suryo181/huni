@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <!-- Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Riwayat Pengajuan Sewa Kos</h3>
        <p class="text-muted small mb-0">Daftar kos yang pernah kamu ajukan pemesanannya.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white">
            <div class="card-body">
                <div class="bg-light d-inline-flex p-3 rounded-circle text-muted mb-3">
                    <i class="bi bi-journal-x fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark">Belum Ada Pengajuan Sewa</h5>
                <p class="text-muted small mb-3">Kamu belum pernah mengajukan sewa kos apa pun.</p>
                <a href="/kos" class="btn btn-huni btn-sm px-4 py-2 fw-bold">Mulai Cari Kos</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($bookings as $booking)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $booking->property->name ?? $booking->room->property->name ?? 'Kos' }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-geo-alt text-danger me-1"></i>
                                    {{ $booking->property->district ?? $booking->room->property->district ?? '-' }}, 
                                    {{ $booking->property->city ?? $booking->room->property->city ?? '-' }}
                                </p>
                            </div>
                            <div>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Konfirmasi</span>
                                @elseif($booking->status == 'approved')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">Dibatalkan / Kadaluwarsa</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-2">

                        <div class="small mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Tipe Kamar:</span>
                                <span class="fw-bold text-dark">{{ $booking->room->name ?? 'Kamar No. ' . ($booking->room->room_number ?? '-') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Harga Bulanan:</span>
                                <span class="fw-bold text-success">Rp {{ number_format($booking->room->price ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Mulai Masuk:</span>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Durasi Sewa:</span>
                                <span class="fw-bold text-dark">{{ $booking->duration_months }} Bulan</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="fw-semibold text-dark">Total Biaya:</span>
                                <span class="fw-bold text-success fs-6">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto pt-2 d-flex gap-2 flex-wrap">
                            @if($booking->status == 'approved')
                                @php
                                    $ownerPhone = $booking->property->contact_number ?? $booking->property->user->phone ?? '628123456789';
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $ownerPhone);
                                    if(str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                    $waText = rawurlencode("Halo, saya " . auth()->user()->name . " terkait pengajuan sewa kos " . ($booking->property->name ?? '') . " yang telah disetujui.");
                                    $hasReviewed = \App\Models\Review::where('booking_id', $booking->id)->exists();
                                @endphp
                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="btn btn-success btn-sm flex-fill fw-bold py-2 rounded-3">
                                    <i class="bi bi-whatsapp me-1"></i> WA Pemilik
                                </a>

                                @if($hasReviewed)
                                    <button type="button" class="btn btn-secondary btn-sm flex-fill fw-bold py-2 rounded-3" disabled>
                                        <i class="bi bi-check-circle-fill me-1"></i> Sudah Diulas
                                    </button>
                                @else
                                    <button type="button" class="btn btn-warning btn-sm flex-fill fw-bold py-2 rounded-3 text-dark" onclick="document.getElementById('nativeReviewModal{{ $booking->id }}').showModal()">
                                        <i class="bi bi-star-fill me-1"></i> Beri Ulasan
                                    </button>
                                @endif
                            @elseif($booking->status == 'pending')
                                <form action="/my-bookings/{{ $booking->id }}/cancel" method="POST" class="flex-fill" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan sewa ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold py-2 rounded-3">
                                        <i class="bi bi-x-circle me-1"></i> Batalkan Pengajuan
                                    </button>
                                </form>
                            @endif
                            
                            <a href="/kos/{{ $booking->property->slug ?? $booking->room->property->slug ?? '#' }}" class="btn btn-outline-secondary btn-sm flex-fill fw-bold py-2 rounded-3">
                                Detail Kos
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- ================= NATIVE DIALOG MODAL (DIJAMIN 100% BISA DIKLIK) ================= -->
@foreach($bookings as $booking)
    @if($booking->status == 'approved' && !(\App\Models\Review::where('booking_id', $booking->id)->exists()))
        <dialog id="nativeReviewModal{{ $booking->id }}" class="border-0 rounded-4 shadow-lg p-0" style="width: 100%; max-width: 500px; backdrop-filter: blur(4px);">
            <div class="card border-0">
                <form action="/reviews" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $booking->property_id ?? $booking->room->property_id }}">
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">Beri Ulasan Kos</h5>
                        <button type="button" class="btn-close" onclick="document.getElementById('nativeReviewModal{{ $booking->id }}').close()"></button>
                    </div>

                    <div class="card-body p-4">
                        <p class="text-muted small mb-3">Bagikan pengalaman tinggalmu di <strong>{{ $booking->property->name ?? $booking->room->property->name ?? 'Kos' }}</strong>.</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Rating Bintang</label>
                            <select name="rating" class="form-select" required>
                                <option value="5" selected>⭐⭐⭐⭐⭐ (5/5) - Sangat Bagus</option>
                                <option value="4">⭐⭐⭐⭐ (4/5) - Bagus</option>
                                <option value="3">⭐⭐⭐ (3/5) - Cukup</option>
                                <option value="2">⭐⭐ (2/5) - Kurang</option>
                                <option value="1">⭐ (1/5) - Buruk</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Komentar / Ulasan Kamu</label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Ceritakan kebersihan, kenyamanan, atau fasilitas kos ini..." required></textarea>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 text-end d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-sm fw-semibold rounded-2" onclick="document.getElementById('nativeReviewModal{{ $booking->id }}').close()">Batal</button>
                        <button type="submit" class="btn btn-huni btn-sm px-4 fw-semibold rounded-2">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </dialog>
    @endif
@endforeach

<style>
    dialog::backdrop {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
@endsection
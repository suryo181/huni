@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
                <h4 class="fw-bold text-dark mb-1">Pengajuan Sewa Kamar</h4>
                <p class="text-muted small mb-4">{{ $room->property->name }} - Kamar {{ $room->room_number }}</p>

                <div class="p-3 bg-light rounded-3 mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Tipe Kamar:</span>
                        <span class="fw-bold small">{{ $room->type }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Harga Sewa / Bulan:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="/rooms/{{ $room->id }}/book" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tanggal Mulai Sewa</label>
                        <input type="date" name="start_date" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Durasi Sewa (Bulan)</label>
                        <select name="duration_months" class="form-select" required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }} Bulan</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Catatan untuk Pemilik (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Saya berencana masuk sore hari..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/kos/{{ $room->property->slug }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-huni px-4">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
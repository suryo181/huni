@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="mb-4">
                    <a href="/kos/{{ $room->property->slug ?? '#' }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Kos
                    </a>
                    <h3 class="fw-bold text-dark mt-2">Form Pengajuan Sewa Kos</h3>
                    <p class="text-muted small mb-0">{{ $room->property->name ?? '-' }} - <span class="fw-semibold text-success">Kamar {{ $room->name ?? $room->room_number }}</span></p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-3">
                        <ul class="mb-0 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/rooms/{{ $room->id }}/book" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge text-success me-2"></i>Data Identitas Penyewa</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Nomor WhatsApp / HP Active</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', auth()->user()->phone ?? '') }}" placeholder="Contoh: 081234567890" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Jenis Kelamin</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-dark">Pekerjaan / Status</label>
                        <select name="occupation" class="form-select @error('occupation') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Pekerjaan / Status --</option>
                            <option value="Mahasiswa" {{ old('occupation') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Karyawan Swasta / PNS" {{ old('occupation') == 'Karyawan Swasta / PNS' ? 'selected' : '' }}>Karyawan Swasta / PNS</option>
                            <option value="Wiraswasta / Freelancer" {{ old('occupation') == 'Wiraswasta / Freelancer' ? 'selected' : '' }}>Wiraswasta / Freelancer</option>
                            <option value="Lainnya" {{ old('occupation') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-event text-success me-2"></i>Detail Rencana Sewa</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Harga Sewa per Bulan</label>
                        <input type="text" class="form-control bg-light fw-bold text-success" value="Rp {{ number_format($room->price, 0, ',', '.') }}" disabled>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Tanggal Mulai Masuk</label>
                            <input type="date" name="start_date" min="{{ date('Y-m-d') }}" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Durasi Sewa (Bulan)</label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', 1) }}" min="1" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-dark">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Bawa kendaraan motor, minta kamar di lantai bawah, dll.">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-huni w-100 py-2.5 fw-bold shadow-sm">Kirim Pengajuan Sewa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
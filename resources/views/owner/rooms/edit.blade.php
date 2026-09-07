@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: calc(100vh - 180px);">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Alert Error Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <!-- Header Judul Persis Tambah Kamar -->
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Edit Data Kamar</h3>
                    <p class="text-muted small mb-0">Properti: <span class="fw-bold text-dark">{{ $room->property->name ?? '' }}</span></p>
                </div>

                <form action="/owner/rooms/{{ $room->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Baris 1: Nomor Kamar & Lantai -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Nomor / Kode Kamar</label>
                            <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" placeholder="Contoh: A-01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">Lantai</label>
                            <input type="number" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}" placeholder="1" required>
                        </div>
                    </div>

                    <!-- Baris 2: Tipe Kamar -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Tipe Kamar</label>
                        <input type="text" name="type" class="form-control" value="{{ old('type', $room->type) }}" placeholder="Contoh: Deluxe AC / Standard Non-AC" required>
                    </div>

                    <!-- Baris 3: Harga Sewa -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Harga Sewa per Bulan (Rp)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', (int)$room->price) }}" placeholder="Contoh: 1200000" required>
                    </div>

                    <!-- Baris 4: Status Kamar -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small mb-1">Status Kamar</label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Terisi</option>
                            <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan / Maintenance</option>
                        </select>
                    </div>

                    <!-- Baris 5: Keterangan Khusus -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small mb-1">Keterangan Khusus (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Kasur ukuran queen, balkon hadap luar...">{{ old('description', $room->description) }}</textarea>
                    </div>

                    <!-- Tombol Aksi Persis Tambah Kamar -->
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <a href="/owner/properties/{{ $room->property_id }}/rooms" class="btn btn-light text-secondary border-0 px-4 py-2 rounded-3 fw-semibold">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-huni px-4 py-2 fw-bold rounded-3 shadow-sm">
                            Simpan Kamar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection 
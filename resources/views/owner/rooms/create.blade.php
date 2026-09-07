@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-white">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1">Tambah Kamar Baru</h4>
                    <p class="text-muted small mb-4">Properti: <strong>{{ $property->name }}</strong></p>

                    <form action="/owner/properties/{{ $property->id }}/rooms" method="POST">
                        @csrf
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nomor / Kode Kamar</label>
                                <input type="text" name="room_number" class="form-control" placeholder="Contoh: A-01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Lantai</label>
                                <input type="number" name="floor" class="form-control" value="1" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tipe Kamar</label>
                            <input type="text" name="type" class="form-control" placeholder="Contoh: Deluxe AC / Standard Non-AC" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Harga Sewa per Bulan (Rp)</label>
                            <input type="number" name="price" class="form-control" placeholder="Contoh: 1200000" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Kamar</label>
                            <select name="status" class="form-select" required>
                                <option value="available">Tersedia</option>
                                <option value="occupied">Terisi</option>
                                <option value="maintenance">Perbaikan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Keterangan Khusus (Opsional)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Kasur ukuran queen, balkon hadap luar..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/owner/properties/{{ $property->id }}/rooms" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-huni px-4">Simpan Kamar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
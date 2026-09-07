@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: calc(100vh - 180px);">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Tombol Kembali Ber-border (Sejajar di atas Card) -->
            <div class="mb-3">
                <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-1.5">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <!-- Header Judul (Sejajar di atas Card) -->
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Edit Properti Kos</h3>
                <p class="text-muted small mb-0">Perbarui informasi detail mengenai kos Anda.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <form action="/owner/properties/{{ $property->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Nama Properti Kos</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $property->name) }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Kategori Gender Kos</label>
                            <select name="gender_type" class="form-select" required>
                                <option value="putra" {{ $property->gender_type == 'putra' ? 'selected' : '' }}>Putra</option>
                                <option value="putri" {{ $property->gender_type == 'putri' ? 'selected' : '' }}>Putri</option>
                                <option value="campur" {{ $property->gender_type == 'campur' ? 'selected' : '' }}>Campur</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Nomor WhatsApp / Kontak</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $property->contact_number) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Kota / Kabupaten</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $property->city) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Kecamatan / Area</label>
                            <input type="text" name="district" class="form-control" value="{{ old('district', $property->district) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Alamat Lengkap Jalan</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $property->address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Deskripsi Kos</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $property->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Peraturan Kos (Opsional)</label>
                        <textarea name="rules" class="form-control" rows="2" placeholder="Contoh: Dilarang membawa hewan peliharaan, jam bertamu maks 22.00">{{ old('rules', $property->rules) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/owner/dashboard" class="btn btn-outline-secondary px-4 fw-semibold rounded-3">Batal</a>
                        <button type="submit" class="btn btn-huni px-4 fw-bold rounded-3">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header dengan Tombol Kembali Ber-border -->
    <div class="mb-3">
        <a href="/owner/dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-3 px-3 py-1.5">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-0">Galeri Foto - {{ $property->name }}</h3>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Form Upload Foto Baru -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold text-dark mb-3">Upload Foto Baru</h5>
                
                <form action="/owner/properties/{{ $property->id }}/photos" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Pilih Gambar Kos</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maksimal 2MB)</small>
                    </div>

                    <button type="submit" class="btn btn-huni w-100 py-2 fw-bold">Upload Foto</button>
                </form>
            </div>
        </div>

        <!-- Daftar Foto Terpasang -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold text-dark mb-3">Daftar Foto Terpasang</h5>

                @if($photos->isEmpty())
                    <p class="text-muted text-center py-4">Belum ada foto yang diunggah untuk kos ini.</p>
                @else
                    <div class="row g-3">
                        @foreach($photos as $photo)
                            <div class="col-6 col-md-4">
                                <div class="position-relative rounded-3 overflow-hidden border shadow-sm group-photo">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto Kos" class="w-100" style="height: 160px; object-fit: cover;">

                                    @if($photo->is_primary)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2 fs-8">Foto Utama</span>
                                    @endif

                                    <!-- Form Tombol Hapus dengan Method DELETE -->
                                    <form action="/owner/properties/{{ $property->id }}/photos/{{ $photo->id }}" method="POST" class="position-absolute bottom-0 end-0 m-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm p-1.5 rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus Foto">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.auth')

@section('content')
<div class="container d-flex align-items-center justify-content-center py-5" style="min-height: 82vh;">
    <div class="row justify-content-center w-100">
        <div class="col-lg-10 col-xl-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    <!-- Kolom Kiri: Visual Branding -->
                    <div class="col-md-6 bg-huni-primary text-white p-5 d-none d-md-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-white text-success fw-bold px-3 py-2 rounded-pill mb-4">HUNI Platform</span>
                            <h2 class="fw-bold display-6 mb-3">Temukan Tempat Tinggal Idealmu.</h2>
                            <p class="text-white-50">Sewa kos lebih transparan, aman, dan tanpa ribet hanya di HUNI.</p>
                        </div>
                        <div class="pt-4 border-top border-white-50 text-white-50 small">
                            &copy; 2026 HUNI. Solusi HUNIan nyaman.
                        </div>
                    </div>

                    <!-- Kolom Kanan: Form Login -->
                    <div class="col-md-6 bg-white p-4 p-md-5 d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                            <p class="text-muted small">Silakan masuk menggunakan akun HUNI Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small border-0 rounded-3 mb-3">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0 fs-6 py-2" value="{{ old('email') }}" required placeholder="nama@email.com">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold text-secondary">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0 fs-6 py-2" required placeholder="Masukkan password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-huni w-100 py-2.5 fw-bold shadow-sm mb-3">
                                Masuk Sekarang <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </form>

                        <div class="text-center mt-3 pt-3 border-top">
                            <span class="text-muted small">Belum punya akun HUNI?</span>
                            <a href="/register" class="text-success small fw-bold text-decoration-none ms-1">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
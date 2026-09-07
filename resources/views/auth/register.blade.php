@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-1 text-center">Daftar Akun HUNI</h3>
                    <p class="text-muted text-center small mb-4">Pilih peran Anda untuk mulai menggunakan HUNI</p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf
                        
                        <!-- Pilihan Role -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Saya mendaftar sebagai:</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="role_tenant" value="tenant" checked>
                                    <label class="btn btn-outline-success w-100 py-2 rounded-2" for="role_tenant">
                                        <i class="bi bi-person me-1"></i> Pencari Kos
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="role_owner" value="owner">
                                    <label class="btn btn-outline-dark w-100 py-2 rounded-2" for="role_owner">
                                        <i class="bi bi-house-door me-1"></i> Pemilik Kos
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Nomor WhatsApp / HP</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="081234567890">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small font-weight-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                        </div>

                        <button type="submit" class="btn btn-huni w-100 py-2 fw-bold">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Sudah punya akun?</span>
                        <a href="/login" class="text-success small fw-bold text-decoration-none ms-1">Masuk di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
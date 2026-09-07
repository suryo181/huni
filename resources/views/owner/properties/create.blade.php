@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Banner Ketentuan Mitra Pemilik Kos (Option 2) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-5 border-success">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success flex-shrink-0">
                        <i class="bi bi-megaphone-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-2">Ketentuan Mitra Pemilik Kos HUNI</h5>
                        <p class="text-muted small mb-3">
                            Selamat datang Mitra HUNI! Sebelum mengunggah unit kos Anda, mohon perhatikan ketentuan publikasi berikut:
                        </p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-top gap-2">
                                    <i class="bi bi-check-circle-fill text-success fs-6 mt-0.5"></i>
                                    <span class="small text-secondary"><strong>Data Kos Valid:</strong> Pastikan foto, alamat, dan tipe kamar diisi dengan data asli dan lengkap.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-top gap-2">
                                    <i class="bi bi-credit-card-fill text-success fs-6 mt-0.5"></i>
                                    <span class="small text-secondary"><strong>Sistem Langganan:</strong> Layanan publikasi promosi kos di HUNI sebesar <strong>Rp 50.000 / kos / bulan</strong>.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-top gap-2">
                                    <i class="bi bi-eye-fill text-success fs-6 mt-0.5"></i>
                                    <span class="small text-secondary"><strong>Visibilitas Publik:</strong> Kos langsung tayang di pencarian utama setelah terverifikasi & langganan aktif.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-top gap-2">
                                    <i class="bi bi-clock-history text-success fs-6 mt-0.5"></i>
                                    <span class="small text-secondary"><strong>Masa Tayang:</strong> Jika langganan habis, kos otomatis tersembunyi tanpa menghapus data kos Anda.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Tambah Properti Kos Baru</h4>
                    
                    <form action="/owner/properties" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Kos</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Kos Melati Sleman" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Kota / Kabupaten</label>
                                <input type="text" name="city" class="form-control" placeholder="Contoh: Sleman" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Kecamatan</label>
                                <input type="text" name="district" class="form-control" placeholder="Contoh: Depok" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Jl. Kaliurang KM 5, Gang Melati No. 12" required></textarea>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Tipe Kos</label>
                                <select name="gender_type" class="form-select" required>
                                    <option value="campur">Campur</option>
                                    <option value="putra">Putra</option>
                                    <option value="putri">Putri</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Nomor WA / Telepon Pengelola</label>
                                <input type="text" name="contact_number" class="form-control" placeholder="081234567890" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi Properti</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan keunggulan dan kondisi kos..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Peraturan Kos (Opsional)</label>
                            <textarea name="rules" class="form-control" rows="2" placeholder="Contoh: Akses 24 jam, tidak boleh membawa hewan..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/owner/dashboard" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-huni px-4">Pengajuan Kos Baru</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
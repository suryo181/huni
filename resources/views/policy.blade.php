@extends('layouts.app')

@section('content')
<style>
    .hero-policy {
        background: radial-gradient(circle at top right, #065f46 0%, #0f172a 70%, #020617 100%);
    }
    .policy-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .policy-card:hover {
        border-color: #10b981;
        box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.08);
    }
    .nav-btn-huni {
        color: #64748b;
        font-weight: 600;
        border-radius: 14px;
        padding: 12px 20px;
        transition: all 0.25s ease;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
    }
    .nav-btn-huni.active-tab {
        background-color: #059669 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
    }
    .icon-box-sm {
        width: 44px;
        height: 44px;
        background-color: rgba(5, 150, 105, 0.1);
        color: #059669;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
    }
</style>

<!-- Hero Section -->
<section class="hero-policy text-white py-5 position-relative">
    <div class="container py-4 text-center">
        <span class="badge px-3 py-2 rounded-pill mb-3 fw-medium border border-success border-opacity-20" style="background-color: rgba(16, 185, 129, 0.15); color: #34d399;">
            <i class="bi bi-shield-lock me-1"></i> Legal & Transparansi Layanan
        </span>
        <h1 class="display-4 fw-bold mb-3">Pusat Kebijakan & Ketentuan HUNI</h1>
        <p class="lead mb-0 mx-auto text-light opacity-75" style="max-width: 650px;">
            Komitmen kami untuk melindungi privasi Anda dan menyajikan standar penggunaan platform yang adil dan transparan.
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container py-3">
        <div class="row g-4">
            
            <!-- Sidebar Navigasi -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm p-3 rounded-4 bg-white sticky-top" style="top: 100px; z-index: 10;">
                    <h6 class="fw-bold text-dark text-uppercase fs-7 tracking-wider mb-3 px-2">Kategori Informasi</h6>
                    <div class="d-flex flex-column gap-2">
                        
                        <!-- Tombol Tab Kebijakan Privasi -->
                        <button onclick="switchTab('privacy')" 
                                id="btn-privacy" 
                                class="nav-btn-huni d-flex align-items-center gap-2 {{ Request::is('kebijakan-privasi') || !Request::is('syarat-dan-ketentuan') ? 'active-tab' : '' }}">
                            <i class="bi bi-shield-check fs-5"></i>
                            <span>Kebijakan Privasi</span>
                        </button>

                        <!-- Tombol Tab Syarat & Ketentuan -->
                        <button onclick="switchTab('terms')" 
                                id="btn-terms" 
                                class="nav-btn-huni d-flex align-items-center gap-2 {{ Request::is('syarat-dan-ketentuan') ? 'active-tab' : '' }}">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                            <span>Syarat & Ketentuan</span>
                        </button>

                    </div>

                    
                </div>
            </div>

            <!-- Konten Area -->
            <div class="col-lg-9">
                
                <!-- Konten 1: Kebijakan Privasi -->
                <div id="content-privacy" class="policy-content-pane {{ Request::is('kebijakan-privasi') || !Request::is('syarat-dan-ketentuan') ? '' : 'd-none' }}">
                    <div class="mb-4">
                        <h3 class="fw-bold text-dark mb-1">Kebijakan Privasi</h3>
                        <p class="text-muted small mb-0">Terakhir diperbarui: Januari 2026</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="policy-card p-4 bg-white">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-database-check"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">1. Pengumpulan Data Pribadi</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    HUNI mengumpulkan informasi penting saat Anda membuat akun, termasuk nama lengkap, alamat email, nomor WhatsApp, serta data identifikasi properti (khusus pemilik). Seluruh informasi ini digunakan secara ketat untuk memvalidasi keamanan transaksi sewa menyewa.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="policy-card p-4 bg-white h-100">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-person-gear"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">2. Penggunaan Data</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    Data Anda digunakan untuk memproses pengajuan pemesanan kamar, memverifikasi status pembayaran langganan pemilik, dan menghubungkan komunikasi langsung antara pencari kos dan pemilik.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="policy-card p-4 bg-white h-100">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-lock"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">3. Keamanan & Enkripsi</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    Kami menerapkan enkripsi standar industri untuk menjamin data kata sandi dan riwayat aktivitas Anda tidak dapat diakses secara ilegal oleh pihak ketiga tanpa izin sah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten 2: Syarat dan Ketentuan -->
                <div id="content-terms" class="policy-content-pane {{ Request::is('syarat-dan-ketentuan') ? '' : 'd-none' }}">
                    <div class="mb-4">
                        <h3 class="fw-bold text-dark mb-1">Syarat dan Ketentuan</h3>
                        <p class="text-muted small mb-0">Aturan dasar penggunaan platform HUNI</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="policy-card p-4 bg-white">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-person-badge"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">1. Ketentuan Akun Pengguna</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    Pengguna wajib memberikan informasi identitas yang jujur dan valid saat pendaftaran. Akun yang terindikasi melakukan penipuan atau penyalahgunaan data akan dinonaktifkan secara permanen oleh sistem moderasi admin.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="policy-card p-4 bg-white h-100">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-house-gear"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">2. Tanggung Jawab Pemilik Kos</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    Pemilik kos bertanggung jawab penuh atas kebenaran foto, ketersediaan kamar, dan kesesuaian harga yang dipublikasikan di platform HUNI.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="policy-card p-4 bg-white h-100">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="icon-box-sm"><i class="bi bi-cash-stack"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">3. Transaksi & Pembayaran</h5>
                                </div>
                                <p class="text-muted small lh-lg mb-0">
                                    HUNI memfasilitasi temu sewa dan pencarian. Pembayaran sewa kamar disepakati transparan antara pemilik dan penyewa sesuai dengan aturan masing-masing properti.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Script Tab Manual (Dijamin 100% Responsif Tanpa Konflik Bootstrap) -->
<script>
    function switchTab(target) {
        // Ambil elemen tombol & konten
        const btnPrivacy = document.getElementById('btn-privacy');
        const btnTerms = document.getElementById('btn-terms');
        const contentPrivacy = document.getElementById('content-privacy');
        const contentTerms = document.getElementById('content-terms');

        if (target === 'privacy') {
            // Aktifkan tombol privasi
            btnPrivacy.classList.add('active-tab');
            btnTerms.classList.remove('active-tab');
            // Tampilkan konten privasi, sembunyikan terms
            contentPrivacy.classList.remove('d-none');
            contentTerms.classList.add('d-none');
            // Ubah URL browser tanpa reload halaman (biar rapi)
            window.history.pushState({}, '', '/kebijakan-privasi');
        } else {
            // Aktifkan tombol terms
            btnTerms.classList.add('active-tab');
            btnPrivacy.classList.remove('active-tab');
            // Tampilkan konten terms, sembunyikan privasi
            contentTerms.classList.remove('d-none');
            contentPrivacy.classList.add('d-none');
            // Ubah URL browser tanpa reload halaman
            window.history.pushState({}, '', '/syarat-dan-ketentuan');
        }
    }
</script>
@endsection
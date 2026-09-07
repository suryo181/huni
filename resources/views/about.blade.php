@extends('layouts.app')

@section('content')
<style>
    /* Styling Dasar & Gradien Elegan */
    .bg-about-hero {
        background: radial-gradient(circle at top right, #065f46 0%, #0f172a 60%, #020617 100%);
    }
    .text-emerald-glow {
        color: #34d399;
        text-shadow: 0 0 20px rgba(52, 211, 153, 0.3);
    }
    
    /* Card Bento Grid dengan Efek Hover Melayang */
    .bento-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .bento-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -15px rgba(5, 150, 105, 0.12);
        border-color: #10b981;
    }
    
    /* Icon Container Modern */
    .icon-badge {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Counter Stat Box */
    .stat-number {
        font-size: 2.75rem;
        font-weight: 800;
        letter-spacing: -1px;
        background: linear-gradient(135deg, #059669 0%, #0f172a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<!-- Hero Section: Narasi Elegan -->
<section class="bg-about-hero text-white py-5 position-relative overflow-hidden">
    <div class="container py-5 text-center position-relative z-1">
        <span class="badge px-3 py-2 rounded-pill mb-3 fw-medium border border-success border-opacity-20 bg-dark bg-opacity-50 text-emerald-glow">
            <i class="bi bi-stars me-1"></i> Redefining Living Experience
        </span>
        <h1 class="display-3 fw-bold mb-4 tracking-tight">
            Transformasi Cara Anda <br class="d-none d-md-block"> Menemukan Ruang Hunian.
        </h1>
        <p class="lead text-slate-300 mx-auto fw-normal lh-lg" style="max-width: 720px; color: #cbd5e1;">
            <strong>HUNI</strong> lahir dari visi untuk mengeliminasi friksi dalam pencarian tempat tinggal. Kami mengintegrasikan kepastian informasi, kejelasan transaksi, dan aksesibilitas langsung demi menghadirkan kenyamanan sewa yang berkelas.
        </p>
    </div>
</section>

<!-- Section Content: Bento Grid Layout (Unik & Tidak Biasa) -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase tracking-wider">Filosfi & Nilai Utama</h6>
            <h2 class="fw-bold text-dark fs-1">Pilar Layanan HUNI</h2>
        </div>

        <!-- Bento Grid Rows -->
        <div class="row g-4">
            
            <!-- Bento 1: Fitur Utama (Ukuran Besar) -->
            <div class="col-lg-8">
                <div class="bento-card p-4 p-md-5 h-100 bg-white">
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div class="icon-badge bg-success bg-opacity-10 text-success mb-3 mb-md-0">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill fs-7">Standar Verifikasi Terpadu</span>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Transparansi Tanpa Kompromi</h3>
                    <p class="text-muted lh-lg mb-0">
                        Kami memahami bahwa kenyamanan berawal dari kepercayaan. Setiap unit properti yang terdaftar melalui proses kurasi data, kepastian visual, dan struktur harga transparan—memastikan apa yang Anda lihat adalah apa yang akan Anda huni.
                    </p>
                </div>
            </div>

            <!-- Bento 2: Statistik / Ringkasan -->
            <div class="col-lg-4">
                <div class="bento-card p-4 p-md-5 h-100 bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-badge bg-primary bg-opacity-10 text-primary mb-3">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Efisien & Cepat</h4>
                        <p class="text-muted small lh-lg">Alur pengajuan sewa digital yang dipangkas tanpa birokrasi rumit.</p>
                    </div>
                    <div class="pt-3 border-top mt-3">
                        <div class="stat-number">100%</div>
                        <span class="text-muted small fw-semibold">Koneksi Langsung Pemilik</span>
                    </div>
                </div>
            </div>

            <!-- Bento 3: Visi Misi Gabungan -->
            <div class="col-lg-4">
                <div class="bento-card p-4 p-md-5 h-100 bg-dark text-white">
                    <div class="icon-badge bg-white bg-opacity-10 text-emerald-glow mb-4">
                        <i class="bi bi-compass"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Visi Strategis</h4>
                    <p class="text-slate-300 small lh-lg mb-0" style="color: #94a3b8;">
                        Menjadi ekosistem penyewaan hunian modern terdepan yang memberdayakan penyewa dan pemilik properti melalui sinergi teknologi.
                    </p>
                </div>
            </div>

            <!-- Bento 4: Layanan Direct Contact -->
            <div class="col-lg-8">
                <div class="bento-card p-4 p-md-5 h-100 bg-white">
                    <div class="row align-items-center h-100">
                        <div class="col-md-7 mb-3 mb-md-0">
                            <div class="icon-badge bg-warning bg-opacity-10 text-warning mb-3">
                                <i class="bi bi-chat-square-heart"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">Interaksi Tanpa Perantara</h3>
                            <p class="text-muted small lh-lg mb-0">
                                Kemudahan berkomunikasi langsung dengan pengelola properti untuk memastikan seluruh preferensi dan kebutuhan sewa Anda terpenuhi dengan presisi.
                            </p>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <a href="/kos" class="btn btn-huni px-4 py-3 shadow-sm rounded-4 w-100 w-md-auto d-inline-block text-center">
                                Eksplorasi Hunian <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Footer Banner Call-to-Action Elegan -->
<section class="py-5 bg-white border-top">
    <div class="container text-center py-4" style="max-width: 680px;">
        <h3 class="fw-bold text-dark mb-3">Siap Menemukan Ruang Ideal Anda?</h3>
        <p class="text-muted mb-4 lh-lg">Mulai penjelajahan hunian terverifikasi sekarang atau hubungi tim konsultan kami untuk informasi lebih lanjut.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">     
            <a href="https: " target="_blank" class="btn btn-outline-dark px-4 py-2.5 rounded-3 fw-semibold">
                <i class="bi bi-whatsapp me-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
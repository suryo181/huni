<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUNI - Cari Tempat Tinggal Tanpa Ribet</title>
    
    <!-- Favicon Logo HUNI -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-huni.png') }}">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --huni-primary: #059669;
            --huni-dark: #0f172a;
        }
        .bg-huni-primary { background-color: var(--huni-primary) !important; }
        .text-huni-primary { color: var(--huni-primary) !important; }
        .btn-huni {
            background-color: var(--huni-primary);
            color: white;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-huni:hover {
            background-color: #047857;
            color: white;
        }
        
        /* Pengaturan Ukuran Logo Maksimal */
        .logo-huni-container {
            display: flex;
            align-items: center;
            height: 50px;
            overflow: visible;
        }
        
        .logo-huni-3d {
            height: 90px;
            width: auto;
            object-fit: contain;
            margin-top: -5px;
            margin-bottom: -5px;
            filter: drop-shadow(0px 3px 10px rgba(5, 150, 105, 0.4));
            transition: transform 0.2s ease;
        }
        .logo-huni-3d:hover {
            transform: scale(1.08);
        }
        .notification-dropdown {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column h-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-2 shadow-sm">
        <div class="container">
            <!-- Logo HUNI 3D Transparan Super Jelas -->
            <a class="navbar-brand logo-huni-container py-0" 
               href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? '/admin/dashboard' : (auth()->user()->role === 'owner' ? '/owner/dashboard' : '/')) : '/' }}">
                <img src="{{ asset('images/logo-huni.png') }}" 
                     alt="HUNI Logo" 
                     class="logo-huni-3d">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center gap-1" href="/kos">
                                <i class="bi bi-search"></i>
                                <span>Cari Kos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center gap-1" href="/tentang-kami">
                                <i class="bi bi-info-circle"></i>
                                <span>Tentang Kami</span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="btn btn-outline-light btn-sm px-3" href="/login">Masuk</a></li>
                        <li class="nav-item"><a class="btn btn-huni btn-sm px-3" href="/register">Daftar</a></li>
                    @endguest

                    @auth
                        <!-- Menu Khusus Admin -->
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold me-2" href="/admin/dashboard">
                                    <i class="bi bi-shield-lock-fill"></i> Moderasi Admin
                                </a>
                            </li>

                        <!-- Menu Khusus Owner -->
                        @elseif(auth()->user()->role === 'owner')
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold me-2" href="/owner/dashboard">
                                    <i class="bi bi-speedometer2"></i> Dashboard Pemilik
                                </a>
                            </li>

                            <!-- Lonceng Notifikasi Pemilik Kos -->
                            @php
                                $unreadNotifications = auth()->user()->unreadNotifications;
                            @endphp
                            <li class="nav-item dropdown me-2 position-relative">
                                <button class="btn btn-dark position-relative rounded-circle p-1.5 d-flex align-items-center justify-content-center notification-dropdown" id="notifDropdownBtn" type="button" style="width: 38px; height: 38px;">
                                    <i class="bi bi-bell-fill fs-5 text-white"></i>
                                    @if($unreadNotifications->count() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 9px;">
                                            {{ $unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2 mt-2" id="notifMenu" style="width: 310px; max-height: 380px; overflow-y: auto;">
                                    <li class="dropdown-header fw-bold text-dark border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                                        <span>Notifikasi Pengajuan</span>
                                        <span class="badge bg-success-subtle text-success">{{ $unreadNotifications->count() }} Baru</span>
                                    </li>

                                    @forelse($unreadNotifications as $notification)
                                        <li class="mb-1">
                                            <a class="dropdown-item p-2 rounded-2 bg-light text-wrap" href="/notifications/{{ $notification->id }}/read">
                                                <div class="fw-bold text-dark small">{{ $notification->data['title'] ?? 'Pengajuan Baru' }}</div>
                                                <div class="text-muted" style="font-size: 12px;">{{ $notification->data['message'] }}</div>
                                                <small class="text-success fw-semibold d-block mt-1" style="font-size: 10px;">
                                                    <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-center py-3 text-muted small">
                                            Tidak ada notifikasi baru
                                        </li>
                                    @endforelse
                                </ul>
                            </li>

                        <!-- Menu Khusus Tenant / Pencari Kos -->
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white d-flex align-items-center gap-1" href="/kos">
                                    <i class="bi bi-search"></i>
                                    <span>Cari Kos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fw-semibold me-2" href="/my-bookings">
                                    <i class="bi bi-journal-text"></i> Sewa Saya
                                </a>
                            </li>
                        @endif

                        <!-- Tautan Tentang Kami untuk Semua Pengguna yang Login -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center gap-1 me-2" href="/tentang-kami">
                                <i class="bi bi-info-circle"></i>
                                <span>Tentang Kami</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <span class="navbar-text text-white fw-bold me-2">
                                Hi, {{ auth()->user()->name }}
                            </span>
                        </li>

                        <!-- Tombol Logout Langsung -->
                        <li class="nav-item">
                            <form action="/logout" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-1.5 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-shrink-0">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 text-white-50">&copy; 2026 HUNI Platform. Cari tempat tinggal tanpa ribet.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/bootstrap.bundle.min.js"></script>

    <!-- Script Manual Toggle Dropdown Notifikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('notifDropdownBtn');
            const menu = document.getElementById('notifMenu');

            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>
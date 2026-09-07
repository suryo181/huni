<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUNI - Masuk / Daftar</title>
    
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
        body {
            background-color: #f8fafc;
        }
        .bg-huni-primary { 
            background-color: var(--huni-primary) !important; 
        }
        .text-huni-primary { 
            color: var(--huni-primary) !important; 
        }
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
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4 position-relative">

    <!-- Tombol Kembali ke Beranda (Pojok Kiri Atas) -->
    <div class="position-absolute top-0 start-0 p-4">
        <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Content Form Login / Register -->
    <main class="w-100">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/bootstrap.bundle.min.js"></script>
</body>
</html>
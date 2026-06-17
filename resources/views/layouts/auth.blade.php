<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — DigiBaca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-visual">
            <div class="brand-mark mb-4" style="width:52px;height:52px;font-size:1.5rem;">
                <i class="bi bi-book"></i>
            </div>
            <h1 class="font-display">Baca tanpa batas, di mana saja.</h1>
            <p>DigiBaca menghadirkan ribuan judul buku PDF & ePub dari penulis Indonesia — gratis maupun premium, langsung dari peramban Anda.</p>
            <div class="d-flex gap-4 mt-4">
                <div>
                    <div class="fs-3 fw-bold text-white font-display">1.000+</div>
                    <div class="small text-white-50">Judul Buku</div>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-white font-display">350+</div>
                    <div class="small text-white-50">Penulis</div>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-white font-display">25rb+</div>
                    <div class="small text-white-50">Pembaca</div>
                </div>
            </div>
        </div>
        <div class="auth-form-side">
            <div class="auth-form-box">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none d-lg-none">
                    <span class="brand-mark"><i class="bi bi-book"></i></span>
                    <span class="font-display fw-bold fs-5" style="color:var(--color-ink);">DigiBaca</span>
                </a>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
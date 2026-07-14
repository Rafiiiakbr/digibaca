{{--
|=============================================================
| FILE: resources/views/layouts/app.blade.php
| Layout publik (landing, katalog, detail buku)
|=============================================================
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Memaksa browser memuat semua aset HTTP lewat protokol aman HTTPS -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
    <title>@yield('title', 'DigiBaca') — Sistem Membaca Buku Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/app.css') }}">
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-digibaca navbar-expand-lg">
        <div class="container">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark"><i class="bi bi-book"></i></span>
                DigiBaca
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Katalog</a>
                    </li>

                    @auth
                        @if(auth()->user()->isReader())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reader.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(auth()->user()->isAuthor())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('author.dashboard') }}">Dashboard Penulis</a>
                            </li>
                        @elseif(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                            </li>
                        @endif

                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="30" height="30" alt="">
                                <span>{{ Str::limit(auth()->user()->nama, 14) }}</span>
                                @if(auth()->user()->isPremium())
                                    <span class="badge badge-premium" style="font-size:0.6rem;">PRO</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                @if(auth()->user()->isReader())
                                <li><a class="dropdown-item" href="{{ route('reader.profile') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('reader.collection') }}"><i class="bi bi-bookmark-heart me-2"></i>Koleksi Saya</a></li>
                                @if(!auth()->user()->isPremium())
                                <li><a class="dropdown-item text-amber fw-semibold" href="{{ route('premium.upgrade') }}"><i class="bi bi-gem me-2"></i>Upgrade Premium</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-digibaca btn-sm" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-digibaca btn-sm" href="{{ route('register') }}">Daftar Gratis</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="container mt-3">
            <div class="alert alert-info d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-ink text-white-50 py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 text-white mb-2">
                        <span class="brand-mark"><i class="bi bi-book"></i></span>
                        <span class="font-display fw-bold fs-5">DigiBaca</span>
                    </div>
                    <p class="small mb-0">Platform membaca buku digital dengan koleksi PDF dan ePub, untuk pembaca masa kini.</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-white small text-uppercase">Navigasi</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li><a href="{{ route('books.index') }}" class="text-white-50">Katalog</a></li>
                        <li><a href="{{ route('register') }}" class="text-white-50">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white small text-uppercase">Untuk Penulis</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('register') }}" class="text-white-50">Mulai Menulis</a></li>
                        <li><a href="#" class="text-white-50">Panduan Upload</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white small text-uppercase">Kontak</h6>
                    <p class="small mb-0">support@digibaca.test<br>Tangerang Selatan, Indonesia</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <p class="small text-center mb-0">&copy; {{ date('Y') }} DigiBaca. Proyek akademik — dibangun dengan Laravel 12.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
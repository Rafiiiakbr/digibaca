<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — DigiBaca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="sidebar-digibaca" id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <span class="mark"><i class="bi bi-book"></i></span> DigiBaca
        </a>
        <nav class="py-2">
            <div class="nav-section-label">Menu Pembaca</div>
            <a href="{{ route('reader.dashboard') }}" class="nav-link {{ request()->routeIs('reader.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('books.index') }}" class="nav-link">
                <i class="bi bi-search"></i> Cari Buku
            </a>
            <a href="{{ route('reader.collection') }}" class="nav-link {{ request()->routeIs('reader.collection') ? 'active' : '' }}">
                <i class="bi bi-bookmark-heart"></i> Koleksi Saya
            </a>
            <a href="{{ route('reader.bookmarks') }}" class="nav-link {{ request()->routeIs('reader.bookmarks') ? 'active' : '' }}">
                <i class="bi bi-bookmark-star"></i> Bookmark
            </a>
            <a href="{{ route('reader.notes') }}" class="nav-link {{ request()->routeIs('reader.notes') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Catatan
            </a>
            <a href="{{ route('reader.history') }}" class="nav-link {{ request()->routeIs('reader.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Baca
            </a>
 
            <div class="nav-section-label">Akun</div>
            <a href="{{ route('reader.profile') }}" class="nav-link {{ request()->routeIs('reader.profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profil
            </a>
            @if(!auth()->user()->isPremium())
            <a href="{{ route('premium.upgrade') }}" class="nav-link" style="color: var(--color-amber);">
                <i class="bi bi-gem"></i> Upgrade Premium
            </a>
            @endif
        </nav>
        <div class="sidebar-user">
            <img src="{{ auth()->user()->avatar_url }}" alt="">
            <div>
                <div class="name">{{ Str::limit(auth()->user()->nama, 16) }}</div>
                <div class="role">{{ auth()->user()->isPremium() ? 'Member Premium' : 'Member Gratis' }}</div>
            </div>
        </div>
    </div>
 
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div>
                <button class="btn btn-sm btn-light d-lg-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold">@yield('page-title', 'Dashboard')</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-digibaca"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
            </form>
        </div>
 
        @if(session('success'))
            <div class="alert alert-success shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info shadow-sm"><i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}</div>
        @endif
 
        @yield('content')
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
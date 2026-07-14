<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') — DigiBaca</title>
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
            <div class="nav-section-label">Administrasi</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Kelola Buku
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <a href="{{ route('admin.premium.index') }}" class="nav-link {{ request()->routeIs('admin.premium.*') ? 'active' : '' }}">
                <i class="bi bi-gem"></i> Kelola Premium
            </a>
 
            <div class="nav-section-label">Akun</div>
            <a href="{{ route('reader.profile') ?? '#' }}" class="nav-link"><i class="bi bi-person-circle"></i> Profil</a>
        </nav>
        <div class="sidebar-user">
            <img src="{{ auth()->user()->avatar_url }}" alt="">
            <div>
                <div class="name">{{ Str::limit(auth()->user()->nama, 16) }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
    </div>
 
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div>
                <button class="btn btn-sm btn-light d-lg-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold">@yield('page-title', 'Dashboard Admin')</span>
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
 
        @yield('content')
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
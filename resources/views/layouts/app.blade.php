<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pustaka Digital') - ReadOn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/mixins/_box-shadow.scss" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; color: #0d6efd; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}"><i class="bi bi-book-half"></i> ReadOn</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-span"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-3">
                            <span class="badge bg-secondary text-capitalize">Role: {{ Auth::user()->role }}</span>
                            @if(Auth::user()->status_premium)
                                <span class="badge bg-warning text-dark"><i class="bi bi-crown-fill"></i> Premium</span>
                            @endif
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-light px-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> Halo, {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    @if(Auth::user()->role == 'admin')
                                        <a class="dropdown-menu-item dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                    @elseif(Auth::user()->role == 'author')
                                        <a class="dropdown-menu-item dropdown-item" href="{{ route('author.dashboard') }}">Dashboard Penulis</a>
                                    @else
                                        <a class="dropdown-menu-item dropdown-item" href="{{ route('reader.dashboard') }}">Dashboard Baca</a>
                                    @endif
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                        <li class="nav-item"><a class="btn btn-primary ms-2 px-4" href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main class="py-2">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
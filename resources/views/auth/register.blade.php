@extends('layouts.auth')
 
@section('title', 'Daftar Akun')
 
@section('content')
<<<<<<< HEAD
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-2 fw-bold">Daftar Akun Reader</h3>
                    <p class="text-muted text-center mb-4">Buat akun Anda untuk menikmati ribuan akses baca buku gratis dan premium.</p>
                    
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                            <small class="text-muted">Diperlukan untuk memvalidasi batasan usia konten buku (cth: Buku 17+).</small>
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mendaftar Sebagai</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="reader" {{ old('role') == 'reader' ? 'selected' : '' }}>Pembaca (Reader)</option>
                                <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Penulis (Author)</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kata Sandi</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 fw-semibold">Registrasi Akun</button>
                    </form>
                    <div class="text-center">
                        <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk di sini</a></p>
                    </div>
                </div>
=======
    <h2 class="font-display mb-1">Buat Akun Baru</h2>
    <p class="text-muted mb-4">Gratis selamanya untuk membaca koleksi buku publik.</p>
 
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-digibaca" placeholder="Nama Anda" required autofocus>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-digibaca" placeholder="nama@email.com" required>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control form-control-digibaca" max="{{ now()->subYears(5)->format('Y-m-d') }}" required>
            <small class="text-muted">Digunakan untuk verifikasi batas usia konten tertentu.</small>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Daftar Sebagai</label>
            <div class="d-flex gap-2">
                <label class="border rounded-3 p-3 flex-fill text-center" style="cursor:pointer;">
                    <input type="radio" name="role" value="reader" class="form-check-input d-block mx-auto mb-1" {{ old('role', 'reader') == 'reader' ? 'checked' : '' }}>
                    <i class="bi bi-book d-block fs-4 mb-1"></i>
                    <span class="small fw-semibold">Pembaca</span>
                </label>
                <label class="border rounded-3 p-3 flex-fill text-center" style="cursor:pointer;">
                    <input type="radio" name="role" value="author" class="form-check-input d-block mx-auto mb-1" {{ old('role') == 'author' ? 'checked' : '' }}>
                    <i class="bi bi-pencil-square d-block fs-4 mb-1"></i>
                    <span class="small fw-semibold">Penulis</span>
                </label>
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
            </div>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Password</label>
            <input type="password" name="password" class="form-control form-control-digibaca" placeholder="Minimal 8 karakter" required>
        </div>
 
        <div class="mb-4">
            <label class="form-label fw-semibold small">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control form-control-digibaca" placeholder="Ulangi password" required>
        </div>
 
        <button type="submit" class="btn btn-digibaca w-100 mb-3">Daftar Sekarang</button>
 
        <p class="text-center small text-muted">
            Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk di sini</a>
        </p>
    </form>
@endsection

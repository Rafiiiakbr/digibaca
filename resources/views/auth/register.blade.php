@extends('layouts.auth')
 
@section('title', 'Daftar Akun')
 
@section('content')
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

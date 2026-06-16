@extends('layouts.app')
@section('title', 'Masuk Akun')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 fw-bold">Selamat Datang Kembali</h3>
                    <p class="text-muted text-center mb-4">Masuk untuk melanjutkan membaca koleksi buku digital Anda.</p>
                    
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 fw-semibold">Masuk Sekarang</button>
                    </form>
                    <div class="text-center">
                        <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar Akun Baru</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
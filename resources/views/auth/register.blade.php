@extends('layouts.app')
@section('title', 'Daftar Akun Baru')

@section('content')
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
            </div>
        </div>
    </div>
</div>
@endsection
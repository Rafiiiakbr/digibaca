@extends('layouts.auth')
 
@section('title', 'Reset Password')
 
@section('content')
    <h2 class="font-display mb-1">Buat Password Baru</h2>
    <p class="text-muted mb-4">Masukkan password baru untuk akun Anda.</p>
 
    @if($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif
 
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control form-control-digibaca" required readonly>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Password Baru</label>
            <input type="password" name="password" class="form-control form-control-digibaca" placeholder="Minimal 8 karakter" required>
        </div>
 
        <div class="mb-4">
            <label class="form-label fw-semibold small">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control form-control-digibaca" required>
        </div>
 
        <button type="submit" class="btn btn-digibaca w-100">Reset Password</button>
    </form>
@endsection
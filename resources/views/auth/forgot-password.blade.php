@extends('layouts.auth')
 
@section('title', 'Lupa Password')
 
@section('content')
    <h2 class="font-display mb-1">Lupa Password?</h2>
    <p class="text-muted mb-4">Masukkan email Anda, kami akan mengirimkan tautan untuk reset password.</p>
 
    @if(session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif
 
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold small">Alamat Email</label>
            <input type="email" name="email" class="form-control form-control-digibaca" placeholder="nama@email.com" required autofocus>
        </div>
 
        <button type="submit" class="btn btn-digibaca w-100 mb-3">Kirim Tautan Reset</button>
 
        <p class="text-center small text-muted">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke halaman masuk</a>
        </p>
    </form>
@endsection
@extends('layouts.auth')
 
@section('title', 'Masuk')
 
@section('content')
    <h2 class="font-display mb-1">Selamat Datang Kembali</h2>
    <p class="text-muted mb-4">Masuk untuk melanjutkan membaca buku favorit Anda.</p>
 
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
        </div>
    @endif
 
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold small">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-digibaca" placeholder="nama@email.com" required autofocus>
        </div>
 
        <div class="mb-2">
            <label class="form-label fw-semibold small">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="passwordInput" class="form-control form-control-digibaca" placeholder="••••••••" required>
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#passwordInput">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
        </div>
 
        <button type="submit" class="btn btn-digibaca w-100 mb-3">Masuk</button>
 
        <p class="text-center small text-muted">
            Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar sekarang</a>
        </p>
    </form>
 
    <div class="mt-4 p-3 rounded-3" style="background: var(--color-bg);">
        <p class="small fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Akun Demo</p>
        <ul class="small text-muted mb-0 ps-3">
            <li>Admin: admin@digibaca.test / password</li>
            <li>Penulis: author@digibaca.test / password</li>
            <li>Pembaca: reader@digibaca.test / password</li>
        </ul>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetSelector = this.getAttribute('data-target');
                const passwordInput = document.querySelector(targetSelector);
                const icon = this.querySelector('i');

                if (passwordInput) {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                }
            });
        });
    });
</script>
@endpush
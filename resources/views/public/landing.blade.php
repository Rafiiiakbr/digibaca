@extends('layouts.app')
@section('title', 'Selamat Datang')

@section('content')
<div class="container py-5">
    <div class="row align-items-center py-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold lh-sm mb-3">Nikmati Pengalaman Membaca Buku Digital Tanpa Batas</h1>
            <p class="lead text-muted mb-4">Akses ribuan e-book berformat PDF dan ePub secara instan. Tulis, publikasikan, dan baca karya favoritmu dalam satu platform modern.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 me-md-2 fw-semibold shadow-sm">Mulai Membaca</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">Masuk</a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="p-5 bg-primary bg-opacity-10 rounded-5">
                <i class="bi bi-book-half text-primary" style="font-size: 8rem;"></i>
                <div class="mt-3 row g-2">
                    <div class="col-4"><span class="badge bg-white text-dark p-2 w-100 shadow-sm">⚡ PDF Reader</span></div>
                    <div class="col-4"><span class="badge bg-white text-dark p-2 w-100 shadow-sm">📖 ePub Reader</span></div>
                    <div class="col-4"><span class="badge bg-white text-dark p-2 w-100 shadow-sm">👑 Freemium</span></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 text-muted opacity-25">

    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <div class="text-primary mb-3"><i class="bi bi-shield-check fs-2"></i></div>
                <h5 class="fw-bold">Verifikasi Usia</h5>
                <p class="text-muted mb-0">Perlindungan konten dengan validasi umur demi kenyamanan pembaca muda.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <div class="text-primary mb-3"><i class="bi bi-feather fs-2"></i></div>
                <h5 class="fw-bold">Ruang Penulis</h5>
                <p class="text-muted mb-0">Unggah karyamu sendiri, tentukan jenis akses, dan jangkau pembacamu secara luas.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <div class="text-primary mb-3"><i class="bi bi-journal-bookmark-fill fs-2"></i></div>
                <h5 class="fw-bold">Bookmark & Catatan</h5>
                <p class="text-muted mb-0">Simpan halaman terakhir yang dibaca dan tandai baris kalimat penting secara real-time.</p>
            </div>
        </div>
    </div>
</div>
@endsection
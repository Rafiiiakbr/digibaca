@extends('layouts.app')
@section('title', 'Dashboard Penulis')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Studio Penulis</h2>
            <p class="text-muted mb-0">Kelola manuskrip dan pantau status publikasi karya Anda.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary fw-semibold"><i class="bi bi-cloud-upload"></i> Unggah Buku Baru</button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Total Buku</span>
                <h3 class="fw-bold text-dark mb-0">{{ $total_buku_saya }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Diverifikasi</span>
                <h3 class="fw-bold text-success mb-0">{{ $buku_diverifikasi }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Menunggu</span>
                <h3 class="fw-bold text-warning mb-0">{{ $buku_menunggu }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Ditolak</span>
                <h3 class="fw-bold text-danger mb-0">{{ $buku_ditolak }}</h3>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <h5 class="fw-bold mb-3">Daftar Karya Terbaru</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Format</th>
                        <th>Akses</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($my_books as $book)
                        <tr>
                            <td><strong>{{ $book->judul }}</strong></td>
                            <td>{{ $book->category->nama_kategori }}</td>
                            <td><span class="badge bg-secondary text-uppercase">{{ $book->format }}</span></td>
                            <td>
                                <span class="badge {{ $book->jenis_akses == 'premium' ? 'bg-warning text-dark' : 'bg-light text-dark' }}">
                                    {{ $book->jenis_akses }}
                                </span>
                            </td>
                            <td>
                                @if($book->status_verifikasi == 'verified')
                                    <span class="text-success small fw-semibold"><i class="bi bi-patch-check-fill"></i> Aktif</span>
                                @elseif($book->status_verifikasi == 'pending')
                                    <span class="text-warning small fw-semibold"><i class="bi bi-clock-history"></i> Review</span>
                                @else
                                    <span class="text-danger small fw-semibold"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-light text-secondary"><i class="bi bi-pencil-square"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Anda belum mengunggah buku apapun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
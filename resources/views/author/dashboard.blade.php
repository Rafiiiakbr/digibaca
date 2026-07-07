{{--
|=============================================================
| FILE: resources/views/author/dashboard.blade.php
|=============================================================
--}}
@extends('layouts.author')

@section('title', 'Dashboard Penulis')
@section('page-title', 'Dashboard Penulis')

@section('content')
<<<<<<< HEAD
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Studio Penulis</h2>
            <p class="text-muted mb-0">Kelola manuskrip dan pantau status publikasi karya Anda.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('author.books.index') }}" class="btn btn-outline-primary fw-semibold">
                <i class="bi bi-journal-bookmarks me-1"></i> Semua Buku Saya
            </a>
            <a href="{{ route('author.books.create') }}" class="btn btn-primary fw-semibold">
                <i class="bi bi-cloud-upload me-1"></i> Unggah Buku Baru
            </a>
        </div>
    </div>
=======
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E0E7FF; color:var(--color-ink);"><i class="bi bi-collection"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Buku</div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

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
                                <a href="{{ route('author.books.edit', $book->id) }}"
                                   class="btn btn-sm btn-light text-secondary" title="Edit Buku">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Anda belum mengunggah buku apapun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
=======
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-patch-check"></i></div>
            <div>
                <div class="stat-value">{{ $stats['verified'] }}</div>
                <div class="stat-label">Diverifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2; color:#991B1B;"><i class="bi bi-eye"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['views']) }}</div>
                <div class="stat-label">Total Dibaca</div>
            </div>
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
        </div>
    </div>
</div>

@if($stats['rejected'] > 0)
<div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle-fill"></i>
    Anda memiliki <strong>{{ $stats['rejected'] }}</strong> buku yang ditolak admin. Periksa alasan penolakan di daftar buku.
</div>
@endif

<div class="card-digibaca">
    <div class="card-header-custom">
        <span><i class="bi bi-clock-history me-2"></i>Buku Terbaru Anda</span>
        <a href="{{ route('author.books.index') }}" class="small">Kelola Buku Saya</a>
    </div>
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Kategori</th>
                    <th>Akses</th>
                    <th>Status</th>
                    <th>Dibaca</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBooks as $book)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $book->cover_url }}" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            <span class="fw-semibold">{{ Str::limit($book->judul, 30) }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $book->category->nama_kategori ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis' }}" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                            {{ ucfirst($book->jenis_akses) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-status-{{ $book->status_verifikasi }}">{{ ucfirst($book->status_verifikasi) }}</span>
                    </td>
                    <td>{{ number_format($book->views) }}</td>
                    <td class="text-end">
                        <a href="{{ route('author.books.edit', $book->id) }}" class="btn btn-sm btn-outline-digibaca"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="bi bi-collection"></i><p class="mb-0">Belum ada buku yang diupload.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 text-center">
    <a href="{{ route('author.books.create') }}" class="btn btn-digibaca btn-lg px-4">
        <i class="bi bi-cloud-upload me-2"></i> Upload Buku Baru
    </a>
</div>

@endsection
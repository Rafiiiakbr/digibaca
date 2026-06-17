{{--
|=============================================================
| FILE: resources/views/author/dashboard.blade.php
|=============================================================
--}}
@extends('layouts.author')

@section('title', 'Dashboard Penulis')
@section('page-title', 'Dashboard Penulis')

@section('content')

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
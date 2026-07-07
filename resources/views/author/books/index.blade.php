<<<<<<< HEAD
@extends('layouts.app')
@section('title', 'Daftar Buku Saya')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1"><i class="bi bi-journal-bookmarks-fill text-primary me-2"></i>Daftar Buku Saya</h2>
            <p class="text-muted mb-0">Kelola semua karya yang telah Anda publikasikan.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('author.books.create') }}" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-circle-fill me-1"></i> Unggah Buku Baru
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Format</th>
                        <th>Akses</th>
                        <th>Status Verifikasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="ps-4">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                         alt="Cover {{ $book->judul }}"
                                         style="width:48px; height:64px; object-fit:cover; border-radius:6px;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                         style="width:48px; height:64px;">
                                        <i class="bi bi-book text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $book->judul }}</strong>
                                @if($book->isbn)
                                    <br><small class="text-muted">ISBN: {{ $book->isbn }}</small>
                                @endif
                            </td>
                            <td>{{ $book->category->nama_kategori ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">{{ $book->format }}</span>
                            </td>
                            <td>
                                @if($book->jenis_akses == 'premium')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-crown-fill me-1"></i>Premium</span>
                                @else
                                    <span class="badge bg-success">Gratis</span>
                                @endif
                            </td>
                            <td>
                                @if($book->status_verifikasi == 'verified')
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        <i class="bi bi-patch-check-fill me-1"></i>Diverifikasi
                                    </span>
                                @elseif($book->status_verifikasi == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning">
                                        <i class="bi bi-clock-history me-1"></i>Menunggu Review
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger">
                                        <i class="bi bi-x-circle-fill me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('author.books.edit', $book->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit Buku">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('author.books.destroy', $book->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Buku">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Anda belum mengunggah buku apapun.<br>
                                <a href="{{ route('author.books.create') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-plus-circle me-1"></i> Unggah Buku Pertama Anda
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($books->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
=======
{{--
|=============================================================
| FILE: resources/views/author/books/index.blade.php
|=============================================================
--}}
@extends('layouts.author')

@section('title', 'Buku Saya')
@section('page-title', 'Buku Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Kelola semua buku yang telah Anda upload.</p>
    <a href="{{ route('author.books.create') }}" class="btn btn-digibaca">
        <i class="bi bi-plus-lg me-1"></i> Upload Buku Baru
    </a>
</div>

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Format</th>
                    <th>Kategori</th>
                    <th>Akses</th>
                    <th>Usia Min.</th>
                    <th>Status</th>
                    <th>Dibaca</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $book->cover_url }}" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            <div>
                                <div class="fw-semibold">{{ Str::limit($book->judul, 35) }}</div>
                                @if($book->status_verifikasi == 'rejected' && $book->alasan_penolakan)
                                    <div class="text-danger small"><i class="bi bi-exclamation-circle"></i> {{ Str::limit($book->alasan_penolakan, 40) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ strtoupper($book->format) }}</span></td>
                    <td class="text-muted">{{ $book->category->nama_kategori ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis' }}" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                            {{ ucfirst($book->jenis_akses) }}
                        </span>
                    </td>
                    <td>{{ $book->minimal_usia > 0 ? $book->minimal_usia . '+' : 'Semua Usia' }}</td>
                    <td><span class="badge-status-{{ $book->status_verifikasi }}">{{ ucfirst($book->status_verifikasi) }}</span></td>
                    <td>{{ number_format($book->views) }}</td>
                    <td class="text-end">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-digibaca me-1" title="Lihat" target="_blank"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('author.books.edit', $book->id) }}" class="btn btn-sm btn-outline-digibaca me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('author.books.destroy', $book->id) }}" method="POST" class="d-inline" data-confirm="Hapus buku ini? Tindakan tidak dapat dibatalkan.">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-collection"></i>
                            <h5>Belum ada buku</h5>
                            <p>Mulai bagikan karya Anda kepada pembaca digital.</p>
                            <a href="{{ route('author.books.create') }}" class="btn btn-digibaca btn-sm">Upload Buku Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $books->links() }}</div>

@endsection
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2

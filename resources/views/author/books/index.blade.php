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

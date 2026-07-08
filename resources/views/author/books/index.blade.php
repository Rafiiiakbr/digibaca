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

{{-- Flash Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width:36px; height:48px;">
                                    <i class="bi bi-book text-white" style="font-size: 0.8rem;"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ Str::limit($book->judul, 35) }}</div>
                                @if($book->isbn)
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">ISBN: {{ $book->isbn }}</small>
                                @endif
                                @if($book->status_verifikasi == 'rejected' && $book->alasan_penolakan)
                                    <div class="text-danger small" style="font-size: 0.75rem;"><i class="bi bi-exclamation-circle"></i> Ditangguhkan: {{ Str::limit($book->alasan_penolakan, 40) }}</div>
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
                    <td class="text-end pe-4">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('author.books.edit', $book->id) }}" class="btn btn-sm btn-outline-digibaca" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('author.books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini? Tindakan tidak dapat dibatalkan.')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state py-5 text-center">
                            <i class="bi bi-collection fs-1 mb-2 d-block text-muted"></i>
                            <h5>Belum ada buku</h5>
                            <p class="text-muted small">Mulai bagikan karya Anda kepada pembaca digital.</p>
                            <a href="{{ route('author.books.create') }}" class="btn btn-digibaca btn-sm mt-2">Upload Buku Pertama</a>
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
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
{{--
|=============================================================
| FILE: resources/views/admin/books/index.blade.php
|=============================================================
--}}
@extends('layouts.admin')

@section('title', 'Kelola Buku')
@section('page-title', 'Kelola Buku')

@section('content')

<div class="card-digibaca p-3 mb-4">
    <form method="GET" action="{{ route('admin.books.index') }}" class="d-flex gap-2">
        <select name="status" class="form-select" data-auto-submit style="max-width:220px;">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </form>
</div>

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Akses</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $book->cover_url }}" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            <span class="fw-semibold">{{ Str::limit($book->judul, 30) }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $book->author->nama ?? '-' }}</td>
                    <td class="text-muted">{{ $book->category->nama_kategori ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis' }}" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                            {{ ucfirst($book->jenis_akses) }}
                        </span>
                    </td>
                    <td><span class="badge-status-{{ $book->status_verifikasi }}">{{ ucfirst($book->status_verifikasi) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('books.show', $book->id) }}" target="_blank" class="btn btn-sm btn-outline-digibaca me-1" title="Lihat"><i class="bi bi-eye"></i></a>

                        @if($book->status_verifikasi !== 'verified')
                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $book->id }}" title="Verifikasi">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        @endif

                        @if($book->status_verifikasi !== 'rejected')
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $book->id }}" title="Tolak">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        @endif

                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline" data-confirm="Hapus buku ini secara permanen?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Verifikasi --}}
                <div class="modal fade" id="verifyModal{{ $book->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.books.verify', $book->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="verified">
                                <div class="modal-header">
                                    <h6 class="modal-title">Verifikasi Buku</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Verifikasi buku <strong>{{ $book->judul }}</strong>? Buku akan tampil di katalog publik.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Tolak --}}
                <div class="modal fade" id="rejectModal{{ $book->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.books.verify', $book->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="rejected">
                                <div class="modal-header">
                                    <h6 class="modal-title">Tolak Buku</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tolak buku <strong>{{ $book->judul }}</strong>. Berikan alasan penolakan:</p>
                                    <textarea name="alasan_penolakan" class="form-control form-control-digibaca" rows="3" required placeholder="cth: Cover tidak sesuai, file tidak dapat dibuka, dll."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Tolak Buku</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="bi bi-journal-x"></i><p class="mb-0">Tidak ada buku ditemukan.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $books->links() }}</div>
@endsection
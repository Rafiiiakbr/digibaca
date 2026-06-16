@extends('layouts.app')
@section('title', 'Kelola Buku')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0">Manajemen Verifikasi Buku</h3>
            <p class="text-muted m-0">Setujui manuskrip penulis agar tampil di katalog atau tolak jika tidak sesuai ketentuan.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Penulis (Author)</th>
                        <th>Format</th>
                        <th>Akses</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center">Aksi Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>
                                <strong class="d-block text-dark">{{ $book->judul }}</strong>
                                <small class="text-muted">Kategori: {{ $book->category->nama_kategori ?? 'Tanpa Kategori' }}</small>
                            </td>
                            <td>{{ $book->author->name ?? $book->author->nama ?? 'Anonim' }}</td>
                            <td><span class="badge bg-secondary text-uppercase">{{ $book->format ?? 'PDF' }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $book->jenis_akses ?? 'Free' }}</span></td>
                            <td class="text-center">
                                @if($book->status_verifikasi == 'verified')
                                    <span class="badge bg-success text-uppercase">Verified</span>
                                AppEnv@elseif($book->status_verifikasi == 'pending')
                                    <span class="badge bg-warning text-dark text-uppercase">Pending</span>
                                @else
                                    <span class="badge bg-danger text-uppercase">Rejected</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($book->status_verifikasi == 'pending')
                                    <div class="d-inline-flex gap-2">
                                        <form action="{{ route('admin.books.verify', $book->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="verified">
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold shadow-sm">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.books.verify', $book->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold shadow-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small bg-light px-2 py-1 rounded border">Selesai Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-5 text-muted">
                                <p class="mb-0 fw-semibold">Belum ada data buku masuk di dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
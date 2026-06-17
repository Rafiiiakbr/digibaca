@extends('layouts.reader')
 
@section('title', 'Bookmark Saya')
@section('page-title', 'Bookmark Saya')
 
@section('content')
<div class="card-digibaca">
    <div class="card-header-custom">
        <span><i class="bi bi-bookmark-star me-2"></i>Semua Bookmark</span>
    </div>
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Halaman</th>
                    <th>Judul Bagian</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookmarks as $bm)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $bm->book->cover_url ?? '' }}" style="width:32px;height:44px;object-fit:cover;border-radius:4px;" alt="">
                            <span class="fw-semibold">{{ Str::limit($bm->book->judul ?? 'Buku dihapus', 30) }}</span>
                        </div>
                    </td>
                    <td>Halaman {{ $bm->halaman }}</td>
                    <td class="text-muted">{{ $bm->judul_halaman ?? '-' }}</td>
                    <td class="text-muted small">{{ \Carbon\Carbon::parse($bm->created_at)->translatedFormat('d M Y, H:i') }}</td>
                    <td class="text-end">
                        @if($bm->book)
                        <a href="{{ route('books.read', $bm->book_id) }}" class="btn btn-sm btn-outline-digibaca me-1"><i class="bi bi-play-fill"></i></a>
                        @endif
                        <form action="{{ route('reader.bookmarks.destroy', $bm->id) }}" method="POST" class="d-inline" data-confirm="Hapus bookmark ini?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state"><i class="bi bi-bookmark"></i><p class="mb-0">Belum ada bookmark.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $bookmarks->links() }}</div>
@endsection
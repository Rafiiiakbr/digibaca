@extends('layouts.reader')
 
@section('title', 'Riwayat Baca')
@section('page-title', 'Riwayat Baca')
 
@section('content')
<div class="row g-3">
    @forelse($history as $h)
    <div class="col-md-6">
        <a href="{{ route('books.read', $h->book_id) }}" class="text-decoration-none">
            <div class="card-digibaca p-3 d-flex flex-row gap-3 align-items-center h-100">
                <img src="{{ $h->book->cover_url ?? '' }}" style="width:55px;height:75px;object-fit:cover;border-radius:6px;" alt="">
                <div class="flex-fill">
                    <div class="fw-semibold" style="color:var(--color-ink);">{{ Str::limit($h->book->judul ?? 'Buku dihapus', 40) }}</div>
                    <div class="text-muted small">oleh {{ $h->book->author->nama ?? '-' }}</div>
                    <div class="progress mt-2" style="height:6px;">
                        @php $progress = $h->book && $h->book->jumlah_halaman ? min(100, round($h->halaman_terakhir / $h->book->jumlah_halaman * 100)) : 0; @endphp
                        <div class="progress-bar" style="background: var(--color-amber); width: {{ $progress }}%;"></div>
                    </div>
                    <div class="text-muted small mt-1">Halaman {{ $h->halaman_terakhir }} &middot; Terakhir dibaca {{ \Carbon\Carbon::parse($h->updated_at)->diffForHumans() }}</div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-clock-history"></i>
            <h5>Belum ada riwayat membaca</h5>
            <a href="{{ route('books.index') }}" class="btn btn-digibaca btn-sm mt-2">Mulai Membaca</a>
        </div>
    </div>
    @endforelse
</div>
<div class="mt-4 d-flex justify-content-center">{{ $history->links() }}</div>
@endsection
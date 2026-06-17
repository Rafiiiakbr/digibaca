@extends('layouts.reader')
 
@section('title', 'Dashboard Pembaca')
@section('page-title', 'Dashboard Pembaca')
 
@section('content')
 
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E0E7FF; color:var(--color-ink);"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-value">{{ $recentHistory->count() }}</div>
                <div class="stat-label">Buku Dalam Progres</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-bookmark-star"></i></div>
            <div>
                <div class="stat-value">{{ $bookmarks->count() }}</div>
                <div class="stat-label">Bookmark Terakhir</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-bookmark-heart"></i></div>
            <div>
                <div class="stat-value">{{ $collection->count() }}</div>
                <div class="stat-label">Buku di Koleksi</div>
            </div>
        </div>
    </div>
</div>
 
@if(!$user->isPremium())
<div class="rounded-4 p-4 mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: linear-gradient(120deg, var(--color-ink), var(--color-ink-light));">
    <div>
        <h5 class="text-white font-display mb-1"><i class="bi bi-gem text-amber me-2"></i>Upgrade ke Premium</h5>
        <p class="text-white-50 mb-0 small">Buka akses ke seluruh koleksi premium hanya dengan Rp99.000.</p>
    </div>
    <a href="{{ route('premium.upgrade') }}" class="btn btn-amber">Upgrade Sekarang</a>
</div>
@endif
 
{{-- Lanjutkan Membaca --}}
<div class="card-digibaca mb-4">
    <div class="card-header-custom">
        <span><i class="bi bi-play-circle me-2"></i>Lanjutkan Membaca</span>
        <a href="{{ route('reader.history') }}" class="small">Lihat Semua</a>
    </div>
    <div class="p-3">
        @if($recentHistory->count() > 0)
            <div class="row g-3">
                @foreach($recentHistory as $h)
                <div class="col-md-4 col-6">
                    <a href="{{ route('books.read', $h->book_id) }}" class="text-decoration-none">
                        <div class="d-flex gap-2 p-2 rounded-3" style="background:var(--color-bg);">
                            <img src="{{ $h->book->cover_url }}" style="width:50px; height:68px; object-fit:cover; border-radius:6px;" alt="">
                            <div class="overflow-hidden">
                                <div class="small fw-semibold text-truncate" style="color:var(--color-ink);">{{ $h->book->judul }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">Halaman {{ $h->halaman_terakhir }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state py-3">
                <i class="bi bi-book"></i>
                <p class="mb-2">Anda belum memulai membaca buku apapun.</p>
                <a href="{{ route('books.index') }}" class="btn btn-digibaca btn-sm">Jelajahi Katalog</a>
            </div>
        @endif
    </div>
</div>
 
<div class="row g-4">
    {{-- Koleksi Saya --}}
    <div class="col-md-6">
        <div class="card-digibaca h-100">
            <div class="card-header-custom">
                <span><i class="bi bi-bookmark-heart me-2"></i>Koleksi Saya</span>
                <a href="{{ route('reader.collection') }}" class="small">Lihat Semua</a>
            </div>
            <div class="p-3">
                @if($collection->count() > 0)
                    @foreach($collection->take(4) as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none d-flex align-items-center gap-2 py-2 border-bottom">
                        <img src="{{ $book->cover_url }}" style="width:38px; height:52px; object-fit:cover; border-radius:4px;" alt="">
                        <div class="small fw-semibold text-truncate" style="color:var(--color-ink);">{{ $book->judul }}</div>
                    </a>
                    @endforeach
                @else
                    <div class="empty-state py-3"><i class="bi bi-heart"></i><p class="mb-0 small">Koleksi Anda masih kosong.</p></div>
                @endif
            </div>
        </div>
    </div>
 
    {{-- Bookmark Terakhir --}}
    <div class="col-md-6">
        <div class="card-digibaca h-100">
            <div class="card-header-custom">
                <span><i class="bi bi-bookmark-star me-2"></i>Bookmark Terakhir</span>
                <a href="{{ route('reader.bookmarks') }}" class="small">Lihat Semua</a>
            </div>
            <div class="p-3">
                @if($bookmarks->count() > 0)
                    @foreach($bookmarks as $bm)
                    <a href="{{ route('books.read', $bm->book_id) }}" class="text-decoration-none d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="small fw-semibold text-truncate" style="color:var(--color-ink); max-width:200px;">{{ $bm->book->judul ?? '—' }}</div>
                        <span class="badge bg-light text-dark border">Hal. {{ $bm->halaman }}</span>
                    </a>
                    @endforeach
                @else
                    <div class="empty-state py-3"><i class="bi bi-bookmark"></i><p class="mb-0 small">Belum ada bookmark.</p></div>
                @endif
            </div>
        </div>
    </div>
</div>
 
{{-- Rekomendasi --}}
<div class="mt-4">
    <h5 class="font-display mb-3"><i class="bi bi-stars text-amber me-2"></i>Rekomendasi Untuk Anda</h5>
    <div class="row g-3">
        @foreach($recommendations as $book)
        <div class="col-6 col-md-3">
            @include('public.partials.book-card', ['book' => $book])
        </div>
        @endforeach
    </div>
</div>
 
@endsection
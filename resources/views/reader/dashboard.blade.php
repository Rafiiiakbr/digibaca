@extends('layouts.reader')
 
@section('title', 'Dashboard Pembaca')
@section('page-title', 'Dashboard Pembaca')
 
@section('content')
<<<<<<< HEAD
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Eksplorasi Buku</h2>
            <p class="text-muted mb-0">Temukan bacaan menarik hari ini sesuai minat Anda.</p>
        </div>
        <div class="col-auto">
            @if(!Auth::user()->status_premium)
                <a href="{{ route('reader.premium.index') }}" class="btn btn-warning fw-semibold shadow-sm text-dark">
                    <i class="bi bi-lightning-charge-fill"></i> Upgrade Premium
                </a>
            @else
                <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                    <i class="bi bi-crown-fill me-1"></i> Member Premium
                </span>
            @endif
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-3"><i class="bi bi-sparkles text-primary"></i> Buku Terbaru</h4>
            <div class="row g-3">
                @forelse($buku_terbaru as $buku)
                    <div class="col-md-6">
                        <div class="card h-100 d-flex flex-row overflow-hidden">
                            <div class="bg-light d-flex align-items-center justify-content-center border-end" style="width: 100px; min-height: 140px;">
                                <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                            </div>
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex gap-1 mb-1">
                                        <span class="badge bg-primary px-2 py-0.5 text-uppercase" style="font-size: 0.65rem;">{{ $buku->format }}</span>
                                        @if($buku->jenis_akses == 'premium')
                                            <span class="badge bg-warning text-dark px-2 py-0.5" style="font-size: 0.65rem;"><i class="bi bi-crown-fill"></i> PRO</span>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold mb-1 text-truncate-2">{{ $buku->judul }}</h6>
                                    <small class="text-muted d-block mb-2">{{ $buku->genre ?? 'Umum' }}</small>
                                </div>
                                <a href="{{ route('reader.read', $buku->id) }}" class="btn btn-sm btn-outline-primary w-100">Baca</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="text-muted">Belum ada buku yang tersedia.</p></div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <h4 class="fw-bold mb-3"><i class="bi bi-bookmark-star text-primary"></i> Bookmark Terakhir</h4>
            <div class="card p-3 mb-4">
                <ul class="list-group list-group-flush">
                    @forelse($last_bookmarks as $bookmark)
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div class="text-truncate me-2">
                                <strong class="d-block text-truncate small">{{ $bookmark->book->judul }}</strong>
                                <small class="text-muted">Halaman / Letak: {{ $bookmark->halaman }}</small>
                            </div>
                            <a href="{{ route('reader.read', $bookmark->book_id) }}"
                               class="btn btn-sm btn-light text-primary flex-shrink-0" title="Lanjutkan Membaca">
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item px-0 py-2 text-muted small">Belum ada halaman yang ditandai.</li>
                    @endforelse
                </ul>
            </div>

            <h4 class="fw-bold mb-3"><i class="bi bi-sticky text-primary"></i> Catatan Terbaru</h4>
            <div class="card p-3">
                @forelse($last_notes as $note)
                    <div class="mb-2 pb-2 border-bottom last-border-0">
                        <span class="fw-bold small d-block">{{ $note->book->judul }}</span>
                        <p class="text-muted small mb-0 text-truncate">{{ $note->isi_catatan }}</p>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Belum ada catatan pribadi yang dibuat.</p>
                @endforelse
=======
 
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
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
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
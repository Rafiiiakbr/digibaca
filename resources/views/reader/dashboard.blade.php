@extends('layouts.app')
@section('title', 'Dashboard Pembaca')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Eksplorasi Buku</h2>
            <p class="text-muted mb-0">Temukan bacaan menarik hari ini sesuai minat Anda.</p>
        </div>
        <div class="col-auto">
            @if(!Auth::user()->status_premium)
                <button class="btn btn-warning fw-semibold shadow-sm text-dark"><i class="bi bi-lightning-charge-fill"></i> Upgrade Premium</button>
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
                                <a href="#" class="btn btn-sm btn-outline-primary w-100">Baca</a>
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
                            <button class="btn btn-sm btn-light text-primary"><i class="bi bi-arrow-right-short"></i></button>
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
            </div>
        </div>
    </div>
</div>
@endsection
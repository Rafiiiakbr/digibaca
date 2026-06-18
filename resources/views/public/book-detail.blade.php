@extends('layouts.app')
 
@section('title', $book->judul)
 
@section('content')
<div class="container py-5">
    <nav class="small text-muted mb-4">
        <a href="{{ route('home') }}" class="text-muted">Beranda</a> /
        <a href="{{ route('books.index') }}" class="text-muted">Katalog</a> /
        <span>{{ Str::limit($book->judul, 40) }}</span>
    </nav>
 
    <div class="row g-5">
        <div class="col-md-4">
            <div class="rounded-4 overflow-hidden shadow-sm sticky-top" style="top:90px; aspect-ratio:3/4; background:linear-gradient(135deg,#ece9f7,#ddd8f0);">
                <img src="{{ $book->cover_url }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $book->judul }}">
            </div>
        </div>
 
        <div class="col-md-8">
            <div class="d-flex gap-2 mb-3">
                <span class="badge-akses {{ $book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis' }}" style="position:static;">
                    {{ $book->jenis_akses == 'premium' ? 'Premium' : 'Gratis' }}
                </span>
                @if($book->minimal_usia > 0)
                    <span class="badge-akses badge-usia" style="position:static;">{{ $book->minimal_usia }}+ Tahun</span>
                @endif
                <span class="badge bg-light text-dark border">{{ strtoupper($book->format) }}</span>
            </div>
 
            <h1 class="font-display mb-1">{{ $book->judul }}</h1>
            <p class="text-muted mb-3">
                Ditulis oleh <strong>{{ $book->author->nama ?? 'Anonim' }}</strong>
                &middot; Kategori <strong>{{ $book->category->nama_kategori ?? '-' }}</strong>
                &middot; Genre <strong>{{ $book->genre }}</strong>
            </p>
 
            <div class="d-flex gap-4 mb-4 text-muted small">
                <span><i class="bi bi-eye me-1"></i>{{ number_format($book->views) }} dibaca</span>
                @if($book->jumlah_halaman)<span><i class="bi bi-file-text me-1"></i>{{ $book->jumlah_halaman }} halaman</span>@endif
                @if($book->tahun_terbit)<span><i class="bi bi-calendar3 me-1"></i>{{ $book->tahun_terbit }}</span>@endif
                @if($book->isbn)<span><i class="bi bi-upc me-1"></i>{{ $book->isbn }}</span>@endif
            </div>
 
            <h5 class="font-display mb-2">Deskripsi</h5>
            <p class="mb-4" style="color: var(--color-text); line-height:1.8;">{{ $book->deskripsi }}</p>
 
            <div class="d-flex gap-3 flex-wrap">
                @auth
                    @if($book->isAccessible(auth()->user()))
                        <a href="{{ route('books.read', $book->id) }}" class="btn btn-digibaca btn-lg px-4">
                            <i class="bi bi-book-half me-1"></i> Baca Sekarang
                        </a>
                    @elseif($book->minimal_usia > 0 && auth()->user()->getAge() < $book->minimal_usia)
                        <button class="btn btn-secondary btn-lg px-4" disabled>
                            <i class="bi bi-shield-lock me-1"></i> Usia Minimal {{ $book->minimal_usia }} Tahun
                        </button>
                    @else
                        <a href="{{ route('premium.upgrade') }}" class="btn btn-amber btn-lg px-4">
                            <i class="bi bi-gem me-1"></i> Upgrade untuk Membaca
                        </a>
                    @endif
 
                    @if(auth()->user()->isReader())
                    <button class="btn btn-outline-digibaca btn-lg btn-toggle-collection {{ $inCollection ? 'text-danger' : '' }}" data-book-id="{{ $book->id }}">
                        <i class="bi {{ $inCollection ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i> {{ $inCollection ? 'Di Koleksi' : 'Simpan ke Koleksi' }}
                    </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-digibaca btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk untuk Membaca
                    </a>
                @endauth
            </div>
        </div>
    </div>
 
    @if($related->count() > 0)
    <hr class="my-5">
    <h4 class="font-display mb-4">Rekomendasi Serupa</h4>
    <div class="row g-4">
        @foreach($related as $rel)
        <div class="col-6 col-md-3">
            @include('public.partials.book-card', ['book' => $rel])
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
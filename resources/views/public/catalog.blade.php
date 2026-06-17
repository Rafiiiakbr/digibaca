@extends('layouts.app')
 
@section('title', 'Katalog Buku')
 
@section('content')
<div class="container py-5">
 
    <div class="mb-4">
        <span class="section-eyebrow">Temukan Buku</span>
        <h2 class="font-display mb-0">Katalog Buku Digital</h2>
    </div>
 
    <div class="card-digibaca p-3 mb-4">
        <form method="GET" action="{{ route('books.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Cari judul, ISBN, atau genre...">
                </div>
            </div>
            <div class="col-md-2">
                <select name="kategori" class="form-select" data-auto-submit>
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }} ({{ $cat->verified_books_count }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="format" class="form-select" data-auto-submit>
                    <option value="">Semua Format</option>
                    <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="epub" {{ request('format') == 'epub' ? 'selected' : '' }}>ePub</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="akses" class="form-select" data-auto-submit>
                    <option value="">Semua Akses</option>
                    <option value="gratis" {{ request('akses') == 'gratis' ? 'selected' : '' }}>Gratis</option>
                    <option value="premium" {{ request('akses') == 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-digibaca w-100">Terapkan</button>
            </div>
        </form>
    </div>
 
    <p class="text-muted small mb-4">Menampilkan {{ $books->total() }} buku</p>
 
    @if($books->count() > 0)
        <div class="row g-4">
            @foreach($books as $book)
            <div class="col-6 col-md-3">
                @include('public.partials.book-card', ['book' => $book])
            </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $books->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-search"></i>
            <h5>Tidak ada buku ditemukan</h5>
            <p>Coba ubah kata kunci atau filter pencarian Anda.</p>
            <a href="{{ route('books.index') }}" class="btn btn-outline-digibaca btn-sm">Reset Filter</a>
        </div>
    @endif
</div>
@endsection
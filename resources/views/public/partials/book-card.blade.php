@php
    // Usage: @include('public.partials.book-card', ['book' => $book])
@endphp
<div class="book-card">
    <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
        <div class="cover-wrap">
            <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}" loading="lazy">
            <span class="badge-akses {{ $book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis' }}">
                {{ $book->jenis_akses == 'premium' ? 'Premium' : 'Gratis' }}
            </span>
            @if($book->minimal_usia > 0)
                <span class="badge-akses badge-usia" style="top:42px;">{{ $book->minimal_usia }}+</span>
            @endif
        </div>
    </a>
    <div class="card-body-custom">
        <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
            <div class="book-title">{{ $book->judul }}</div>
        </a>
        <div class="book-author">{{ $book->author->nama ?? 'Anonim' }}</div>
        <div class="book-meta">
            <span><i class="bi bi-tag"></i> {{ $book->category->nama_kategori ?? '-' }}</span>
            <span><i class="bi bi-eye"></i> {{ number_format($book->views) }}</span>
        </div>
    </div>
</div>
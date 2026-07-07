@extends('layouts.reader')
 
@section('title', 'Koleksi Saya')
@section('page-title', 'Koleksi Saya')
 
@section('content')
@if($books->count() > 0)
    <div class="row g-4">
        @foreach($books as $book)
        <div class="col-6 col-md-3">
            @include('public.partials.book-card', ['book' => $book])
        </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $books->links() }}</div>
@else
    <div class="empty-state">
        <i class="bi bi-bookmark-heart"></i>
        <h5>Koleksi Anda kosong</h5>
        <p>Simpan buku favorit Anda untuk dibaca nanti.</p>
        <a href="{{ route('books.index') }}" class="btn btn-digibaca btn-sm">Jelajahi Katalog</a>
    </div>
@endif
@endsection
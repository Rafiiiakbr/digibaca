@extends('layouts.author')
 
@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
 
@section('content')
 
<div class="card-digibaca p-4">
    @if($book->status_verifikasi == 'rejected' && $book->alasan_penolakan)
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Buku ini ditolak:</strong> {{ $book->alasan_penolakan }}
        </div>
    @endif
 
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif
 
    <div class="alert alert-info small">
        <i class="bi bi-info-circle me-1"></i> Mengubah data buku akan mengirimkannya kembali ke proses verifikasi admin.
    </div>
 
    <form method="POST" action="{{ route('author.books.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('author.books._form', ['book' => $book])
 
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-digibaca px-4"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
            <a href="{{ route('author.books.index') }}" class="btn btn-light px-4">Batal</a>
        </div>
    </form>
</div>
 
@endsection
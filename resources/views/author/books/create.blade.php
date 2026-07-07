@extends('layouts.author')
 
@section('title', 'Upload Buku Baru')
@section('page-title', 'Upload Buku Baru')
 
@section('content')
 
<div class="card-digibaca p-4">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif
 
    <form method="POST" action="{{ route('author.books.store') }}" enctype="multipart/form-data">
        @csrf
        @include('author.books._form', ['book' => null])
 
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-digibaca px-4"><i class="bi bi-cloud-upload me-1"></i> Upload Buku</button>
            <a href="{{ route('author.books.index') }}" class="btn btn-light px-4">Batal</a>
        </div>
    </form>
</div>
 
@endsection
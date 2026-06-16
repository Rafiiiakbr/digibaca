@extends('layouts.app')
@section('title', 'Upload Buku Baru')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border p-4 shadow-sm bg-white">
                <h4 class="fw-bold mb-4 text-center"><i class="fa-solid fa-book-medical text-primary me-2"></i>Formulir Publikasi Buku Baru</h4>
                <hr>
                
                <form action="{{ route('author.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Buku Digital *</label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Contoh: Belajar Laravel 12 Komplit" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kategori Utama *</label>
                                    <select name="kategori_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Genre / Sub-Kategori</label>
                                    <input type="text" name="genre" class="form-control" placeholder="Contoh: Edukasi, Pemrograman">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nomor ISBN (Opsional)</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="978-3-16-148410-0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Format Dokumen Digital *</label>
                                    <select name="format" class="form-select" required>
                                        <option value="pdf">Berkas PDF (.pdf)</option>
                                        <option value="epub">Berkas ePub (.epub)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Ringkas / Sinopsis</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis sinopsis ringkas buku Anda agar menarik minat pembaca..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-5 border-start ps-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-danger">Jenis Akses Konten *</label>
                                <select name="jenis_akses" class="form-select border-danger" required>
                                    <option value="gratis">Gratis (Dapat dibaca semua user)</option>
                                    <option value="premium">Premium (Hanya untuk member premium aktif)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-warning">Batasan Minimal Usia Pembaca *</label>
                                <input type="number" name="minimal_usia" class="form-control border-warning" value="0" min="0" required>
                                <small class="text-muted d-block mt-1">Isi <strong>0</strong> jika buku ini aman dibaca untuk semua umur (anak-anak hingga dewasa).</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar Cover Buku (JPG/PNG, Maks 2MB) *</label>
                                <input type="file" name="cover" class="form-control" accept="image/*" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">File Dokumen Buku Digital (Maks 50MB) *</label>
                                <input type="file" name="file_buku" class="form-control" required>
                                <small class="text-muted">Pastikan ekstensi berkas sesuai pilihan format (.pdf atau .epub).</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('author.dashboard') }}" class="btn btn-light px-4 rounded-pill">Batalkan</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pillfw-bold">Ajukan Buku ke Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
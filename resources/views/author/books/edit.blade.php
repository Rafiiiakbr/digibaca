@extends('layouts.app')
@section('title', 'Edit Buku: ' . $book->judul)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border p-4 shadow-sm bg-white">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('author.books.index') }}" class="btn btn-sm btn-light me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Buku</h4>
                        <small class="text-muted">{{ $book->judul }}</small>
                    </div>
                </div>

                @if($book->status_verifikasi == 'rejected')
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Buku ini sebelumnya ditolak oleh admin.</strong> Silakan perbaiki isi buku dan ajukan ulang.
                    </div>
                @endif

                <hr>

                <form action="{{ route('author.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Buku Digital *</label>
                                <input type="text" name="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul', $book->judul) }}"
                                    placeholder="Contoh: Belajar Laravel 12 Komplit" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kategori Utama *</label>
                                    <select name="kategori_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('kategori_id', $book->kategori_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Genre / Sub-Kategori</label>
                                    <input type="text" name="genre" class="form-control"
                                        value="{{ old('genre', $book->genre) }}"
                                        placeholder="Contoh: Edukasi, Pemrograman">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nomor ISBN (Opsional)</label>
                                    <input type="text" name="isbn" class="form-control"
                                        value="{{ old('isbn', $book->isbn) }}"
                                        placeholder="978-3-16-148410-0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Format Dokumen Digital *</label>
                                    <select name="format" class="form-select" required>
                                        <option value="pdf" {{ old('format', $book->format) == 'pdf' ? 'selected' : '' }}>
                                            Berkas PDF (.pdf)
                                        </option>
                                        <option value="epub" {{ old('format', $book->format) == 'epub' ? 'selected' : '' }}>
                                            Berkas ePub (.epub)
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Ringkas / Sinopsis</label>
                                <textarea name="deskripsi" class="form-control" rows="4"
                                    placeholder="Tulis sinopsis ringkas buku Anda...">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-5 border-start ps-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-danger">Jenis Akses Konten *</label>
                                <select name="jenis_akses" class="form-select border-danger" required>
                                    <option value="free" {{ old('jenis_akses', $book->jenis_akses) == 'free' ? 'selected' : '' }}>
                                        Gratis (Dapat dibaca semua user)
                                    </option>
                                    <option value="premium" {{ old('jenis_akses', $book->jenis_akses) == 'premium' ? 'selected' : '' }}>
                                        Premium (Hanya untuk member premium aktif)
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-warning">Batasan Minimal Usia Pembaca *</label>
                                <input type="number" name="minimal_usia" class="form-control border-warning"
                                    value="{{ old('minimal_usia', $book->minimal_usia) }}" min="0" required>
                                <small class="text-muted d-block mt-1">Isi <strong>0</strong> jika aman untuk semua umur.</small>
                            </div>

                            {{-- Cover saat ini --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Cover Buku Saat Ini</label>
                                @if($book->cover)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $book->cover) }}"
                                             alt="Cover Saat Ini"
                                             class="rounded border"
                                             style="max-height: 140px; object-fit: cover;">
                                    </div>
                                @else
                                    <p class="text-muted small">Belum ada cover.</p>
                                @endif
                                <label class="form-label fw-semibold">Ganti Cover (JPG/PNG, Maks 2MB)</label>
                                <input type="file" name="cover" class="form-control"
                                    accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti cover.</small>
                                @error('cover') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Ganti File Buku (PDF/ePub, Maks 50MB)</label>
                                <input type="file" name="file_buku" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti file buku.</small>
                                @error('file_buku') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="alert alert-info mb-4 small">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Setelah Anda menyimpan perubahan, buku akan dikembalikan ke status <strong>Menunggu Review</strong> dan perlu diverifikasi ulang oleh Admin.
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('author.books.index') }}" class="btn btn-light px-4 rounded-pill">Batalkan</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

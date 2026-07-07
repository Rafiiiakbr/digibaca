{{--
|=============================================================
| FILE: resources/views/admin/categories/index.blade.php
|=============================================================
--}}
@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Kelola kategori buku yang tersedia di platform.</p>
    <button class="btn btn-digibaca" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </button>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Buku</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td><i class="bi {{ $cat->icon ?? 'bi-book' }} fs-5" style="color:var(--color-ink);"></i></td>
                    <td class="fw-semibold">{{ $cat->nama_kategori }}</td>
                    <td class="text-muted">{{ Str::limit($cat->deskripsi, 50) ?: '-' }}</td>
                    <td>{{ $cat->books_count }}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-digibaca me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $cat->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" data-confirm="Hapus kategori ini?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editCategoryModal{{ $cat->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h6 class="modal-title font-display">Edit Kategori</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Nama Kategori</label>
                                        <input type="text" name="nama_kategori" value="{{ $cat->nama_kategori }}" class="form-control form-control-digibaca" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Icon (Bootstrap Icons class)</label>
                                        <input type="text" name="icon" value="{{ $cat->icon }}" class="form-control form-control-digibaca" placeholder="bi-book">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Deskripsi</label>
                                        <textarea name="deskripsi" rows="2" class="form-control form-control-digibaca">{{ $cat->deskripsi }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-digibaca">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr><td colspan="5"><div class="empty-state"><i class="bi bi-tags"></i><p class="mb-0">Belum ada kategori.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $categories->links() }}</div>

{{-- Modal Create --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title font-display">Tambah Kategori Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-digibaca" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Icon (Bootstrap Icons class)</label>
                        <input type="text" name="icon" class="form-control form-control-digibaca" placeholder="bi-book">
                        <small class="text-muted">Lihat referensi di <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" rows="2" class="form-control form-control-digibaca"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-digibaca">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
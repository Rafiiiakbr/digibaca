<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $book->judul }} — DigiBaca Reader</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body style="overflow:hidden;">
 
<div class="reader-shell" id="reader-shell">
 
    <div class="reader-topbar">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('books.show', $book->id) }}" class="reader-toolbar-btn" title="Kembali">
                <i class="bi bi-arrow-left"></i>
            </a>
            <span class="reader-title">{{ $book->judul }}</span>
        </div>
 
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="reader-toolbar-btn" id="btn-zoom-out" title="Perkecil"><i class="bi bi-zoom-out"></i></button>
            <span class="text-white small" id="zoom-level">100%</span>
            <button class="reader-toolbar-btn" id="btn-zoom-in" title="Perbesar"><i class="bi bi-zoom-in"></i></button>
 
            <span class="text-white-50 mx-1">|</span>
 
            <button class="reader-toolbar-btn" id="btn-prev-page" title="Halaman Sebelumnya"><i class="bi bi-chevron-left"></i></button>
            <span class="text-white small">
                <input type="number" id="page-input" value="1" min="1" style="width:50px; text-align:center; border-radius:4px; border:none; padding:2px;">
                / <span id="page-count">-</span>
            </span>
            <button class="reader-toolbar-btn" id="btn-next-page" title="Halaman Berikutnya"><i class="bi bi-chevron-right"></i></button>
 
            <span class="text-white-50 mx-1">|</span>
 
            <button class="reader-toolbar-btn" id="btn-bookmark" title="Tambah Bookmark"><i class="bi bi-bookmark-plus"></i></button>
            <button class="reader-toolbar-btn" id="btn-note" title="Tambah Catatan" data-bs-toggle="modal" data-bs-target="#noteModal"><i class="bi bi-journal-plus"></i></button>
            <button class="reader-toolbar-btn" id="btn-panel" title="Panel Bookmark & Catatan"><i class="bi bi-list-ul"></i></button>
        </div>
    </div>
 
    <div class="reader-canvas-wrap" id="canvas-wrap">
        <div id="pdf-canvas-container">
            <canvas id="pdf-canvas"></canvas>
        </div>
    </div>
</div>
 
{{-- Side panel: bookmarks & notes for this book --}}
<div class="reader-sidepanel" id="side-panel">
    <div class="panel-header">
        <span><i class="bi bi-bookmark-star me-2"></i>Bookmark & Catatan</span>
        <button class="btn btn-sm btn-light" id="btn-close-panel"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="panel-body">
        <h6 class="small fw-bold text-muted text-uppercase mb-2">Bookmark</h6>
        <div id="bookmark-list" class="mb-4">
            <p class="text-muted small">Memuat...</p>
        </div>
        <h6 class="small fw-bold text-muted text-uppercase mb-2">Catatan</h6>
        <div id="note-list">
            <p class="text-muted small">Memuat...</p>
        </div>
    </div>
</div>
 
{{-- Modal: Add Note --}}
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-display">Tambah Catatan — Halaman <span id="note-page-label">1</span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quick-note-form">
                <div class="modal-body">
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="halaman" id="note-halaman-input" value="1">
                    <textarea name="isi_catatan" class="form-control form-control-digibaca" rows="4" placeholder="Tulis catatan Anda di sini..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-digibaca">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    window.DIGIBACA_BOOK = {
        id: {{ $book->id }},
        fileUrl: "{{ $book->file_url }}",
        lastPage: {{ $history->halaman_terakhir ?? 1 }},
    };
</script>
<script src="{{ asset('assets/js/pdf-reader.js') }}"></script>
 
</body>
</html>
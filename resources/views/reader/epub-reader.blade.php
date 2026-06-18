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
            <button class="reader-toolbar-btn" id="btn-font-smaller" title="Perkecil Teks"><i class="bi bi-dash-lg"></i></button>
            <span class="text-white small" id="font-size-label">100%</span>
            <button class="reader-toolbar-btn" id="btn-font-larger" title="Perbesar Teks"><i class="bi bi-plus-lg"></i></button>
 
            <span class="text-white-50 mx-1">|</span>
 
            <button class="reader-toolbar-btn" id="btn-theme-toggle" title="Mode Gelap/Terang"><i class="bi bi-moon-stars"></i></button>
            <button class="reader-toolbar-btn" id="btn-toc" title="Daftar Isi"><i class="bi bi-list"></i></button>
 
            <span class="text-white-50 mx-1">|</span>
 
            <button class="reader-toolbar-btn" id="btn-prev-chapter" title="Sebelumnya"><i class="bi bi-chevron-left"></i></button>
            <span class="text-white small" id="progress-label">0%</span>
            <button class="reader-toolbar-btn" id="btn-next-chapter" title="Berikutnya"><i class="bi bi-chevron-right"></i></button>
 
            <span class="text-white-50 mx-1">|</span>
 
            <button class="reader-toolbar-btn" id="btn-bookmark" title="Tambah Bookmark"><i class="bi bi-bookmark-plus"></i></button>
            <button class="reader-toolbar-btn" id="btn-note" title="Tambah Catatan" data-bs-toggle="modal" data-bs-target="#noteModal"><i class="bi bi-journal-plus"></i></button>
            <button class="reader-toolbar-btn" id="btn-panel" title="Panel"><i class="bi bi-list-ul"></i></button>
        </div>
    </div>
 
    <div class="reader-canvas-wrap" id="canvas-wrap">
        <div id="epub-viewer-container"></div>
    </div>
</div>
 
{{-- TOC Panel --}}
<div class="reader-sidepanel" id="toc-panel">
    <div class="panel-header">
        <span><i class="bi bi-list-ul me-2"></i>Daftar Isi</span>
        <button class="btn btn-sm btn-light" id="btn-close-toc"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="panel-body" id="toc-list">
        <p class="text-muted small">Memuat daftar isi...</p>
    </div>
</div>
 
{{-- Bookmark/Note Panel --}}
<div class="reader-sidepanel" id="side-panel">
    <div class="panel-header">
        <span><i class="bi bi-bookmark-star me-2"></i>Bookmark & Catatan</span>
        <button class="btn btn-sm btn-light" id="btn-close-panel"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="panel-body">
        <button class="btn btn-sm btn-outline-digibaca w-100 mb-3" id="btn-bookmark-panel">
            <i class="bi bi-bookmark-plus me-1"></i> Tandai Posisi Ini
        </button>
        <p class="text-muted small">Bookmark dan catatan lengkap dapat dilihat di dashboard Anda pada menu "Bookmark" dan "Catatan".</p>
    </div>
</div>
 
{{-- Modal: Add Note --}}
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-display">Tambah Catatan</h6>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/epubjs@0.3.93/dist/epub.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    window.DIGIBACA_BOOK = {
        id: {{ $book->id }},
        fileUrl: "{{ $book->file_url }}",
        lastCfi: @json($history->cfi_terakhir ?? null),
    };
</script>
<script src="{{ asset('assets/js/epub-reader.js') }}"></script>
 
</body>
</html>
 

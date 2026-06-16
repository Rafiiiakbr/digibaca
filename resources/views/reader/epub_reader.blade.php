@extends('layouts.app')
@section('title', 'Membaca ePub: ' . $book->judul)

@section('styles')
<style>
    #epub-area { background-color: #fff; border: 1px solid #dee2e6; height: 70vh; position: relative; border-radius: 8px; box-shadow: inset 0 0 10px rgba(0,0,0,0.05); }
    .reader-sidebar { border-left: 1px solid #dee2e6; background-color: #fff; height: 85vh; overflow-y: auto; }
    .control-bar { background-color: #212529; color: #fff; padding: 10px; border-radius: 5px; }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Area Utama Reader ePub -->
        <div class="col-md-8 col-lg-9 mb-4">
            <div class="d-flex justify-content-between align-items-center control-bar mb-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <a href="{{ route('reader.dashboard') }}" class="btn btn-sm btn-outline-light me-3 rounded-pill">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <h6 class="mb-0 text-truncate fw-bold" style="max-width: 250px;">{{ $book->judul }}</h6>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button id="epub-prev" class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-chevron-left"></i></button>
                    <span class="small fw-semibold">Gunakan Tombol Navigasi Halaman</span>
                    <button id="epub-next" class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fa-solid fa-file-code me-1"></i> Format ePub</span>
                </div>
            </div>

            <!-- Kontainer Utama Rendering Engine -->
            <div id="epub-area" class="p-3">
                <div id="epub-loading" class="position-absolute top-50 start-50 translate-middle text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <p class="text-muted">Menyusun Struktur Teks ePub...</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Catatan -->
        <div class="col-md-4 col-lg-3">
            <div class="card reader-sidebar p-3 shadow-sm rounded">
                <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fa-regular fa-note-sticky text-success me-2"></i>Catatan ePub</h5>
                
                <div class="mb-3">
                    <textarea id="note-input" class="form-control form-control-sm mb-2" rows="3" placeholder="Tulis catatan penting..."></textarea>
                    <button id="btn-save-note" class="btn btn-success btn-sm w-100 rounded-pill fw-bold">Simpan Catatan</button>
                </div>

                <div id="notes-wrapper" class="d-flex flex-column gap-2 mt-2">
                    <!-- Diisi via AJAX dinamis -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load library resmi epub.js via jszip pendukung CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/epubjs/dist/epub.min.js"></script>
<script>
    const epubUrl = "{{ asset($book->file_buku) }}";
    const bookId = "{{ $book->id }}";
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Inisialisasi Engine epub.js Book object
    const book = ePub(epubUrl);
    const rendition = book.renderTo("epub-area", {
        width: "100%",
        height: "100%",
        flow: "paginated" // Mode lembar per lembar buku fisik
    });

    // Tampilkan konten ePub
    rendition.display().then(() => {
        document.getElementById('epub-loading').style.display = 'none';
    });

    // Handler Aksi Tombol Navigasi Lembar Halaman
    document.getElementById('epub-prev').addEventListener('click', () => rendition.prev());
    document.getElementById('epub-next').addEventListener('click', () => rendition.next());

    // Fitur Catatan Asinkron AJAX Terintegrasi (Sama dengan kode PDF)
    const loadNotes = () => {
        fetch(`/api/notes/${bookId}`, { headers: { 'Authorization': `Bearer ${token}` } })
            .then(res => res.json())
            .then(res => {
                const wrapper = document.getElementById('notes-wrapper');
                wrapper.innerHTML = '';
                res.data.forEach(note => {
                    wrapper.innerHTML += `
                        <div class="p-2 bg-light border rounded text-sm position-relative">
                            <p class="mb-1 text-muted" style="font-size:13px;">${note.isi_catatan}</p>
                            <div class="text-end">
                                <button onclick="deleteNote(${note.id})" class="btn btn-link text-danger text-xs p-0 border-0" style="font-size:11px; text-decoration:none;"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </div>
                        </div>`;
                });
            });
    };

    document.getElementById('btn-save-note').addEventListener('click', () => {
        const txt = document.getElementById('note-input').value;
        if(!txt.trim()) return;

        fetch('/api/notes/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Authorization': `Bearer ${token}` },
            body: JSON.stringify({ book_id: bookId, isi_catatan: txt })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById('note-input').value = '';
                loadNotes();
            }
        });
    });

    window.deleteNote = (id) => {
        fetch(`/api/notes/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Authorization': `Bearer ${token}` }
        }).then(() => loadNotes());
    };

    loadNotes();
</script>
@endsection
@extends('layouts.app')
@section('title', 'Membaca: ' . $book->judul)

@section('styles')
<style>
    body { overflow-x: hidden; }
    #reader-container { background-color: #525659; min-height: 85vh; padding: 20px; position: relative; }
    #pdf-canvas { display: block; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.3); background-color: #fff; max-width: 100%; }
    .reader-sidebar { border-left: 1px solid #dee2e6; background-color: #fff; height: 85vh; overflow-y: auto; }
    .control-bar { background-color: #343a40; color: #fff; padding: 10px; border-radius: 5px; }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <!-- Area Utama Reader PDF -->
        <div class="col-md-8 col-lg-9 mb-4">
            <div class="d-flex justify-content-between align-items-center control-bar mb-2 shadow-sm">
                <div class="d-flex align-items-center">
                    <a href="{{ route('reader.dashboard') }}" class="btn btn-sm btn-outline-light me-3 rounded-pill">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <h6 class="mb-0 text-truncate fw-bold" style="max-width: 250px;">{{ $book->judul }}</h6>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button id="prev-page" class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-chevron-left"></i></button>
                    <span class="small">Halaman <strong id="page-num">1</strong> dari <strong id="page-count">-</strong></span>
                    <button id="next-page" class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
                <div>
                    <button id="btn-bookmark" class="btn btn-sm btn-warning rounded-pill px-3">
                        <i class="fa-regular fa-bookmark me-1"></i> <span id="bookmark-text">Simpan Bookmark</span>
                    </button>
                </div>
            </div>

            <div id="reader-container" class="rounded d-flex align-items-center justify-content-center">
                <div id="loading-status" class="text-white text-center">
                    <div class="spinner-border text-light mb-2" role="status"></div>
                    <p>Memuat Dokumen PDF...</p>
                </div>
                <canvas id="pdf-canvas" style="display: none;"></canvas>
            </div>
        </div>

        <!-- Sidebar Interaktif Catatan Pribadi -->
        <div class="col-md-4 col-lg-3">
            <div class="card reader-sidebar p-3 shadow-sm rounded">
                <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fa-regular fa-note-sticky text-primary me-2"></i>Catatan Saya</h5>
                
                <!-- Form Tambah Catatan -->
                <div class="mb-3">
                    <textarea id="note-input" class="form-control form-control-sm mb-2" rows="3" placeholder="Tulis catatan penting dari halaman ini..."></textarea>
                    <button id="btn-save-note" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold">Simpan Catatan</button>
                </div>

                <!-- Kontainer List Catatan Terambil -->
                <div id="notes-wrapper" class="d-flex flex-column gap-2 mt-2">
                    <!-- Data dimuat dinamis via JS -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load library resmi PDF.js via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script>
    // Konfigurasi Worker Lokasi Asal PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    const url = "{{ asset($book->file_buku) }}";
    const bookId = "{{ $book->id }}";
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumPending = null;

    const scale = 1.3,
          canvas = document.getElementById('pdf-canvas'),
          ctx = canvas.getContext('2d');

    // Ambil Data Render Halaman PDF
    const renderPage = num => {
        pageIsRendering = true;

        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderCtx = { canvasContext: ctx, viewport };

            page.render(renderCtx).promise.then(() => {
                pageIsRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });

            document.getElementById('page-num').textContent = num;
        });
    };

    const queueRenderPage = num => {
        if (pageIsRendering) { pageNumPending = num; } else { renderPage(num); }
    };

    // Navigasi Halaman
    document.getElementById('prev-page').addEventListener('click', () => {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    });

    document.getElementById('next-page').addEventListener('click', () => {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    });

    // Sinkronisasi Pemulihan Posisi Bookmark Awal via REST API
    fetch(`/api/bookmark/check/${bookId}`, { headers: { 'Authorization': `Bearer ${token}` } })
        .then(res => res.json())
        .then(resData => {
            if(resData.success) { pageNum = resData.halaman; }
            
            // Memulai Load Dokumen Utama
            pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
                pdfDoc = pdfDoc_;
                document.getElementById('page-count').textContent = pdfDoc.numPages;
                document.getElementById('loading-status').style.display = 'none';
                canvas.style.display = 'block';
                renderPage(pageNum);
            }).catch(err => {
                document.getElementById('loading-status').innerHTML = `<p class="text-danger">Gagal memuat file PDF: ${err.message}</p>`;
            });
        });

    // Aksi Klik Simpan Bookmark Mandiri
    document.getElementById('btn-bookmark').addEventListener('click', () => {
        fetch('/api/bookmark/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Authorization': `Bearer ${token}` },
            body: JSON.stringify({ book_id: bookId, halaman: pageNum })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById('bookmark-text').textContent = "Tersimpan v";
                setTimeout(() => { document.getElementById('bookmark-text').textContent = "Simpan Bookmark"; }, 2000);
            }
        });
    });

    // --- LOGIKA ASYNC MANAJEMEN CATATAN (SIDEBAR) ---
    const loadNotes = () => {
        fetch(`/api/notes/${bookId}`, { headers: { 'Authorization': `Bearer ${token}` } })
            .then(res => res.json())
            .then(res => {
                const wrapper = document.getElementById('notes-wrapper');
                wrapper.innerHTML = '';
                res.data.forEach(note => {
                    wrapper.innerHTML += `
                        <div class="p-2 bg-light border rounded position-relative shadow-sm text-sm">
                            <p class="mb-1 text-secondary" style="font-size: 13px;">${note.isi_catatan}</p>
                            <div class="text-end">
                                <button onclick="deleteNote(${note.id})" class="btn btn-xs text-danger p-0 border-0" style="font-size: 11px;"><i class="fa-solid fa-trash-can"></i> Hapus</button>
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

    // Muat list catatan pertama kali
    loadNotes();
</script>
@endsection
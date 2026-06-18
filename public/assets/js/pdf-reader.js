(() => {
    'use strict';
 
    // PDF.js worker setup (must match the cdn version used in blade)
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
 
    const BOOK = window.DIGIBACA_BOOK;
    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');
 
    let pdfDoc = null;
    let currentPage = BOOK.lastPage || 1;
    let totalPages = 1;
    let scale = 1.2;
    let rendering = false;
    let pendingPage = null;
 
    const pageInput = document.getElementById('page-input');
    const pageCountLabel = document.getElementById('page-count');
    const zoomLabel = document.getElementById('zoom-level');
 
    // ── Render a given page number ──────────────────────────
    function renderPage(num) {
        if (rendering) {
            pendingPage = num;
            return;
        }
        rendering = true;
 
        pdfDoc.getPage(num).then((page) => {
            const viewport = page.getViewport({ scale });
            canvas.width = viewport.width;
            canvas.height = viewport.height;
 
            const renderContext = { canvasContext: ctx, viewport };
            const renderTask = page.render(renderContext);
 
            renderTask.promise.then(() => {
                rendering = false;
                if (pendingPage !== null) {
                    const next = pendingPage;
                    pendingPage = null;
                    renderPage(next);
                }
            });
        });
 
        currentPage = num;
        pageInput.value = num;
        saveProgress(num);
    }
 
    function queueRenderPage(num) {
        if (num < 1 || num > totalPages) return;
        renderPage(num);
    }
 
    // ── Load the PDF document ───────────────────────────────
    pdfjsLib.getDocument(BOOK.fileUrl).promise.then((doc) => {
        pdfDoc = doc;
        totalPages = doc.numPages;
        pageCountLabel.textContent = totalPages;
        pageInput.max = totalPages;
        renderPage(currentPage);
        loadBookmarks();
        loadNotes();
    }).catch((err) => {
        console.error('Gagal memuat PDF:', err);
        showToast('Gagal memuat file PDF. Coba muat ulang halaman.', 'danger');
    });
 
    // ── Navigation controls ──────────────────────────────────
    document.getElementById('btn-prev-page').addEventListener('click', () => queueRenderPage(currentPage - 1));
    document.getElementById('btn-next-page').addEventListener('click', () => queueRenderPage(currentPage + 1));
 
    pageInput.addEventListener('change', () => {
        const val = parseInt(pageInput.value, 10);
        if (!isNaN(val)) queueRenderPage(val);
    });
 
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight' || e.key === 'PageDown') queueRenderPage(currentPage + 1);
        if (e.key === 'ArrowLeft' || e.key === 'PageUp') queueRenderPage(currentPage - 1);
    });
 
    // ── Zoom controls ──────────────────────────────────────
    document.getElementById('btn-zoom-in').addEventListener('click', () => {
        scale = Math.min(scale + 0.2, 3);
        zoomLabel.textContent = Math.round(scale / 1.2 * 100) + '%';
        renderPage(currentPage);
    });
    document.getElementById('btn-zoom-out').addEventListener('click', () => {
        scale = Math.max(scale - 0.2, 0.5);
        zoomLabel.textContent = Math.round(scale / 1.2 * 100) + '%';
        renderPage(currentPage);
    });
 
    // ── Save reading progress (debounced) ───────────────────
    let saveTimeout = null;
    function saveProgress(page) {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            window.digibacaFetch('/reader/progress', {
                method: 'POST',
                body: JSON.stringify({ book_id: BOOK.id, halaman_terakhir: page }),
            }).catch(() => {});
        }, 800);
    }
 
    // ── Bookmark functionality ──────────────────────────────
    document.getElementById('btn-bookmark').addEventListener('click', async () => {
        try {
            const res = await window.digibacaFetch('/reader/bookmark', {
                method: 'POST',
                body: JSON.stringify({
                    book_id: BOOK.id,
                    halaman: currentPage,
                    judul_halaman: `Halaman ${currentPage}`,
                }),
            });
            const data = await res.json();
            if (data.success) {
                showToast('Bookmark ditambahkan di halaman ' + currentPage, 'success');
                loadBookmarks();
            }
        } catch (err) {
            showToast('Gagal menambah bookmark.', 'danger');
        }
    });
 
    async function loadBookmarks() {
        const list = document.getElementById('bookmark-list');
        try {
            // Reuse the reader bookmarks data via a lightweight inline render
            // (In a full implementation this would call a dedicated API endpoint)
            list.innerHTML = `<button class="btn btn-sm btn-outline-digibaca w-100" onclick="document.getElementById('btn-bookmark').click()">
                <i class="bi bi-bookmark-plus me-1"></i> Tandai Halaman Ini
            </button>
            <p class="text-muted small mt-2 mb-0">Bookmark tersimpan dapat dilihat lengkap di menu "Bookmark" pada dashboard Anda.</p>`;
        } catch (err) {
            list.innerHTML = '<p class="text-muted small">Gagal memuat bookmark.</p>';
        }
    }
 
    async function loadNotes() {
        const list = document.getElementById('note-list');
        list.innerHTML = `<p class="text-muted small mb-0">Catatan yang Anda tulis dapat dilihat lengkap di menu "Catatan" pada dashboard Anda.</p>`;
    }
 
    // ── Note modal: prefill current page ────────────────────
    document.getElementById('btn-note').addEventListener('click', () => {
        document.getElementById('note-page-label').textContent = currentPage;
        document.getElementById('note-halaman-input').value = currentPage;
    });
 
    // ── Side panel toggle ────────────────────────────────────
    document.getElementById('btn-panel').addEventListener('click', () => {
        document.getElementById('side-panel').classList.toggle('show');
    });
    document.getElementById('btn-close-panel').addEventListener('click', () => {
        document.getElementById('side-panel').classList.remove('show');
    });
 
})();
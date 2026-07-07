/* ===========================================================
   FILE: public/assets/js/epub-reader.js
   Integrasi epub.js — Reader DigiBaca
   =========================================================== */

(() => {
    'use strict';

    const BOOK = window.DIGIBACA_BOOK;

    const book = ePub(BOOK.fileUrl);
    const rendition = book.renderTo('epub-viewer-container', {
        width: '100%',
        height: '100%',
        spread: 'auto',
    });

    let fontSize = 100;
    let isDarkMode = false;
    let currentLocation = null;

    // ── Display book — resume from last CFI or start ────────
    const displayed = BOOK.lastCfi
        ? rendition.display(BOOK.lastCfi)
        : rendition.display();

    displayed.then(() => {
        applyTheme();
    }).catch((err) => {
        console.error('Gagal memuat ePub:', err);
        showToast('Gagal memuat file ePub. Coba muat ulang halaman.', 'danger');
    });

    // ── Generate locations for progress percentage ─────────
    book.ready.then(() => {
        return book.locations.generate(1600);
    }).then(() => {
        updateProgress();
    });

    // ── Track location changes ──────────────────────────────
    rendition.on('relocated', (location) => {
        currentLocation = location;
        updateProgress();
        saveProgress(location.start.cfi);

        document.getElementById('note-halaman-input').value = location.start.cfi;
    });

    function updateProgress() {
        if (currentLocation && book.locations.length()) {
            const percent = Math.round(book.locations.percentageFromCfi(currentLocation.start.cfi) * 100);
            document.getElementById('progress-label').textContent = percent + '%';
        }
    }

    // ── Navigation ───────────────────────────────────────────
    document.getElementById('btn-prev-chapter').addEventListener('click', () => rendition.prev());
    document.getElementById('btn-next-chapter').addEventListener('click', () => rendition.next());

    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight') rendition.next();
        if (e.key === 'ArrowLeft') rendition.prev();
    });

    // ── Font size controls ──────────────────────────────────
    document.getElementById('btn-font-larger').addEventListener('click', () => {
        fontSize = Math.min(fontSize + 10, 200);
        rendition.themes.fontSize(fontSize + '%');
        document.getElementById('font-size-label').textContent = fontSize + '%';
    });
    document.getElementById('btn-font-smaller').addEventListener('click', () => {
        fontSize = Math.max(fontSize - 10, 60);
        rendition.themes.fontSize(fontSize + '%');
        document.getElementById('font-size-label').textContent = fontSize + '%';
    });

    // ── Theme toggle (dark/light reading mode) ──────────────
    rendition.themes.register('light', { body: { background: '#fdfaf3', color: '#1F2937' } });
    rendition.themes.register('dark', { body: { background: '#1a1a22', color: '#e5e5e5' } });

    function applyTheme() {
        rendition.themes.select(isDarkMode ? 'dark' : 'light');
    }

    document.getElementById('btn-theme-toggle').addEventListener('click', () => {
        isDarkMode = !isDarkMode;
        applyTheme();
        const icon = document.querySelector('#btn-theme-toggle i');
        icon.className = isDarkMode ? 'bi bi-sun' : 'bi bi-moon-stars';
    });

    // ── Table of Contents ────────────────────────────────────
    book.loaded.navigation.then((toc) => {
        const tocList = document.getElementById('toc-list');
        tocList.innerHTML = '';
        toc.forEach((chapter) => {
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'd-block py-2 border-bottom small text-decoration-none';
            item.style.color = 'var(--color-text)';
            item.textContent = chapter.label;
            item.addEventListener('click', (e) => {
                e.preventDefault();
                rendition.display(chapter.href);
                document.getElementById('toc-panel').classList.remove('show');
            });
            tocList.appendChild(item);
        });
    });

    document.getElementById('btn-toc').addEventListener('click', () => {
        document.getElementById('toc-panel').classList.toggle('show');
        document.getElementById('side-panel').classList.remove('show');
    });
    document.getElementById('btn-close-toc').addEventListener('click', () => {
        document.getElementById('toc-panel').classList.remove('show');
    });

    // ── Side panel (bookmark/note) ───────────────────────────
    document.getElementById('btn-panel').addEventListener('click', () => {
        document.getElementById('side-panel').classList.toggle('show');
        document.getElementById('toc-panel').classList.remove('show');
    });
    document.getElementById('btn-close-panel').addEventListener('click', () => {
        document.getElementById('side-panel').classList.remove('show');
    });

    // ── Save reading progress (debounced) ───────────────────
    let saveTimeout = null;
    function saveProgress(cfi) {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            window.digibacaFetch('/reader/progress', {
                method: 'POST',
                body: JSON.stringify({ book_id: BOOK.id, halaman_terakhir: 1, cfi_terakhir: cfi }),
            }).catch(() => {});
        }, 800);
    }

    // ── Bookmark functionality ──────────────────────────────
    function addBookmark() {
        if (!currentLocation) return;
        window.digibacaFetch('/reader/bookmark', {
            method: 'POST',
            body: JSON.stringify({
                book_id: BOOK.id,
                halaman: 1,
                judul_halaman: 'Posisi tersimpan',
                cfi_position: currentLocation.start.cfi,
            }),
        }).then(res => res.json()).then((data) => {
            if (data.success) showToast('Bookmark berhasil disimpan!', 'success');
        }).catch(() => showToast('Gagal menambah bookmark.', 'danger'));
    }

    document.getElementById('btn-bookmark').addEventListener('click', addBookmark);
    document.getElementById('btn-bookmark-panel').addEventListener('click', addBookmark);

})();
document.addEventListener('DOMContentLoaded', () => {
 
    // ── CSRF setup for fetch() calls ───────────────────────
    window.CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;
 
    window.digibacaFetch = (url, options = {}) => {
        return fetch(url, {
            ...options,
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'Accept': 'application/json',
                ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
                ...options.headers,
            },
        });
    };
 
    // ── Toast helper ────────────────────────────────────────
    window.showToast = (message, type = 'success') => {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.position = 'fixed';
            container.style.top = '20px';
            container.style.right = '20px';
            container.style.zIndex = '2000';
            document.body.appendChild(container);
        }
 
        const icon = type === 'success' ? 'check-circle-fill' : (type === 'danger' ? 'x-circle-fill' : 'info-circle-fill');
 
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} shadow d-flex align-items-center gap-2 mb-2`;
        toast.style.minWidth = '280px';
        toast.style.animation = 'slideInToast 0.25s ease';
        toast.innerHTML = `<i class="bi bi-${icon}"></i> <span>${message}</span>`;
        container.appendChild(toast);
 
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = '0.3s';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };
 
    // ── Toggle Collection (wishlist heart button) ───────────
    document.querySelectorAll('.btn-toggle-collection').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const bookId = btn.dataset.bookId;
            btn.disabled = true;
 
            try {
                const res = await window.digibacaFetch('/reader/koleksi', {
                    method: 'POST',
                    body: JSON.stringify({ book_id: bookId }),
                });
                const data = await res.json();
 
                if (data.success) {
                    btn.classList.toggle('text-danger', data.added);
                    const icon = btn.querySelector('i');
                    if (icon) icon.className = data.added ? 'bi bi-heart-fill' : 'bi bi-heart';
                    showToast(data.message, 'success');
                }
            } catch (err) {
                showToast('Gagal memproses permintaan.', 'danger');
            } finally {
                btn.disabled = false;
            }
        });
    });
 
    // ── Search form auto-submit on category select ─────────
    document.querySelectorAll('[data-auto-submit]').forEach(el => {
        el.addEventListener('change', () => el.closest('form')?.submit());
    });
 
    // ── Confirm delete dialogs ──────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm(form.dataset.confirm || 'Apakah Anda yakin?')) {
                e.preventDefault();
            }
        });
    });
 
    // ── Password visibility toggle ──────────────────────────
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(btn.dataset.target);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.querySelector('i').className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    });
 
    // ── File input preview (cover image) ────────────────────
    document.querySelectorAll('.cover-input').forEach(input => {
        input.addEventListener('change', () => {
            const preview = document.querySelector(input.dataset.preview);
            if (preview && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
        });
    });
 
    // ── Note quick-add modal (used in reader views) ─────────
    const noteForm = document.getElementById('quick-note-form');
    if (noteForm) {
        noteForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(noteForm);
 
            try {
                const res = await window.digibacaFetch('/reader/catatan', {
                    method: 'POST',
                    body: JSON.stringify(Object.fromEntries(formData)),
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Catatan berhasil disimpan.', 'success');
                    noteForm.reset();
                    bootstrap.Modal.getInstance(document.getElementById('noteModal'))?.hide();
                }
            } catch (err) {
                showToast('Gagal menyimpan catatan.', 'danger');
            }
        });
    }
});
 
const style = document.createElement('style');
style.textContent = `@keyframes slideInToast { from { transform: translateX(100%); opacity:0; } to { transform: translateX(0); opacity:1; } }`;
document.head.appendChild(style);
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Judul Buku</label>
        <input type="text" name="judul" value="<?php echo e(old('judul', $book->judul ?? '')); ?>" class="form-control form-control-digibaca" required>
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">ISBN (opsional)</label>
        <input type="text" name="isbn" value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>" class="form-control form-control-digibaca" placeholder="978-xxx-xxx-xxx-x">
    </div>
 
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Kategori</label>
        <select name="kategori_id" class="form-select form-control-digibaca" required>
            <option value="">Pilih Kategori</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(old('kategori_id', $book->kategori_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                    <?php echo e($cat->nama_kategori); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Genre</label>
        <input type="text" name="genre" value="<?php echo e(old('genre', $book->genre ?? '')); ?>" class="form-control form-control-digibaca" placeholder="cth: Drama, Horor, Self Help" required>
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Bahasa</label>
        <select name="bahasa" class="form-select form-control-digibaca">
            <option value="Indonesia" <?php echo e(old('bahasa', $book->bahasa ?? 'Indonesia') == 'Indonesia' ? 'selected' : ''); ?>>Indonesia</option>
            <option value="Inggris" <?php echo e(old('bahasa', $book->bahasa ?? '') == 'Inggris' ? 'selected' : ''); ?>>Inggris</option>
        </select>
    </div>
 
    <div class="col-12">
        <label class="form-label small fw-semibold">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="form-control form-control-digibaca" placeholder="Minimal 50 karakter..." required><?php echo e(old('deskripsi', $book->deskripsi ?? '')); ?></textarea>
    </div>
 
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Penerbit</label>
        <input type="text" name="penerbit" value="<?php echo e(old('penerbit', $book->penerbit ?? '')); ?>" class="form-control form-control-digibaca">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="<?php echo e(old('tahun_terbit', $book->tahun_terbit ?? '')); ?>" class="form-control form-control-digibaca" min="1900" max="<?php echo e(date('Y')); ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Jumlah Halaman</label>
        <input type="number" name="jumlah_halaman" value="<?php echo e(old('jumlah_halaman', $book->jumlah_halaman ?? '')); ?>" class="form-control form-control-digibaca" min="1">
    </div>
 
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Jenis Akses</label>
        <select name="jenis_akses" class="form-select form-control-digibaca" required>
            <option value="gratis" <?php echo e(old('jenis_akses', $book->jenis_akses ?? '') == 'gratis' ? 'selected' : ''); ?>>Gratis</option>
            <option value="premium" <?php echo e(old('jenis_akses', $book->jenis_akses ?? '') == 'premium' ? 'selected' : ''); ?>>Premium</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Batas Usia Minimal</label>
        <select name="minimal_usia" class="form-select form-control-digibaca" required>
            <option value="0" <?php echo e(old('minimal_usia', $book->minimal_usia ?? 0) == 0 ? 'selected' : ''); ?>>Semua Usia</option>
            <option value="13" <?php echo e(old('minimal_usia', $book->minimal_usia ?? '') == 13 ? 'selected' : ''); ?>>13+ Tahun</option>
            <option value="17" <?php echo e(old('minimal_usia', $book->minimal_usia ?? '') == 17 ? 'selected' : ''); ?>>17+ Tahun</option>
            <option value="18" <?php echo e(old('minimal_usia', $book->minimal_usia ?? '') == 18 ? 'selected' : ''); ?>>18+ Tahun (Dewasa)</option>
        </select>
    </div>
 
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Cover Buku <?php echo e($book ? '(kosongkan jika tidak diubah)' : ''); ?></label>
        <input type="file" name="cover" class="form-control cover-input" data-preview="#coverPreview" accept="image/*" <?php echo e($book ? '' : 'required'); ?>>
        <?php if($book && $book->cover): ?>
            <img id="coverPreview" src="<?php echo e($book->cover_url); ?>" class="mt-2 rounded" style="width:80px; height:106px; object-fit:cover;">
        <?php else: ?>
            <img id="coverPreview" class="mt-2 rounded d-none" style="width:80px; height:106px; object-fit:cover;">
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">File Buku (PDF/ePub, max 50MB) <?php echo e($book ? '(kosongkan jika tidak diubah)' : ''); ?></label>
        <input type="file" name="file_buku" class="form-control" accept=".pdf,.epub" <?php echo e($book ? '' : 'required'); ?>>
        <?php if($book): ?>
            <small class="text-muted">File saat ini: <?php echo e($book->file_buku); ?> (<?php echo e(strtoupper($book->format)); ?>)</small>
        <?php endif; ?>
    </div>
</div>
 
<script>
    // Show preview when a new cover is selected (even without prior cover)
    document.querySelector('.cover-input')?.addEventListener('change', () => {
        document.getElementById('coverPreview')?.classList.remove('d-none');
    });
</script><?php /**PATH C:\buku-digital\resources\views/author/books/_form.blade.php ENDPATH**/ ?>
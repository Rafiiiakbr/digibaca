
<?php $__env->startSection('title', 'Upload Buku Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border p-4 shadow-sm bg-white">
                <h4 class="fw-bold mb-4 text-center"><i class="fa-solid fa-book-medical text-primary me-2"></i>Formulir Publikasi Buku Baru</h4>
                <hr>
                
                <form action="<?php echo e(route('author.books.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Buku Digital *</label>
                                <input type="text" name="judul" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('judul')); ?>" placeholder="Contoh: Belajar Laravel 12 Komplit" required>
                                <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kategori Utama *</label>
                                    <select name="kategori_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->nama_kategori); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Genre / Sub-Kategori</label>
                                    <input type="text" name="genre" class="form-control" placeholder="Contoh: Edukasi, Pemrograman">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nomor ISBN (Opsional)</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="978-3-16-148410-0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Format Dokumen Digital *</label>
                                    <select name="format" class="form-select" required>
                                        <option value="pdf">Berkas PDF (.pdf)</option>
                                        <option value="epub">Berkas ePub (.epub)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Ringkas / Sinopsis</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis sinopsis ringkas buku Anda agar menarik minat pembaca..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-5 border-start ps-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-danger">Jenis Akses Konten *</label>
                                <select name="jenis_akses" class="form-select border-danger" required>
                                    <option value="gratis">Gratis (Dapat dibaca semua user)</option>
                                    <option value="premium">Premium (Hanya untuk member premium aktif)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-warning">Batasan Minimal Usia Pembaca *</label>
                                <input type="number" name="minimal_usia" class="form-control border-warning" value="0" min="0" required>
                                <small class="text-muted d-block mt-1">Isi <strong>0</strong> jika buku ini aman dibaca untuk semua umur (anak-anak hingga dewasa).</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar Cover Buku (JPG/PNG, Maks 2MB) *</label>
                                <input type="file" name="cover" class="form-control" accept="image/*" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">File Dokumen Buku Digital (Maks 50MB) *</label>
                                <input type="file" name="file_buku" class="form-control" required>
                                <small class="text-muted">Pastikan ekstensi berkas sesuai pilihan format (.pdf atau .epub).</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('author.dashboard')); ?>" class="btn btn-light px-4 rounded-pill">Batalkan</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pillfw-bold">Ajukan Buku ke Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/author/books/create.blade.php ENDPATH**/ ?>
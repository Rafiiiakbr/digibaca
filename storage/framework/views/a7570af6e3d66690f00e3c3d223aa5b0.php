
<?php $__env->startSection('title', 'Dashboard Penulis'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Studio Penulis</h2>
            <p class="text-muted mb-0">Kelola manuskrip dan pantau status publikasi karya Anda.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="<?php echo e(route('author.books.index')); ?>" class="btn btn-outline-primary fw-semibold">
                <i class="bi bi-journal-bookmarks me-1"></i> Semua Buku Saya
            </a>
            <a href="<?php echo e(route('author.books.create')); ?>" class="btn btn-primary fw-semibold">
                <i class="bi bi-cloud-upload me-1"></i> Unggah Buku Baru
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Total Buku</span>
                <h3 class="fw-bold text-dark mb-0"><?php echo e($total_buku_saya); ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Diverifikasi</span>
                <h3 class="fw-bold text-success mb-0"><?php echo e($buku_diverifikasi); ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Menunggu</span>
                <h3 class="fw-bold text-warning mb-0"><?php echo e($buku_menunggu); ?></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center bg-white">
                <span class="text-muted small d-block mb-1">Ditolak</span>
                <h3 class="fw-bold text-danger mb-0"><?php echo e($buku_ditolak); ?></h3>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <h5 class="fw-bold mb-3">Daftar Karya Terbaru</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Format</th>
                        <th>Akses</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $my_books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($book->judul); ?></strong></td>
                            <td><?php echo e($book->category->nama_kategori); ?></td>
                            <td><span class="badge bg-secondary text-uppercase"><?php echo e($book->format); ?></span></td>
                            <td>
                                <span class="badge <?php echo e($book->jenis_akses == 'premium' ? 'bg-warning text-dark' : 'bg-light text-dark'); ?>">
                                    <?php echo e($book->jenis_akses); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($book->status_verifikasi == 'verified'): ?>
                                    <span class="text-success small fw-semibold"><i class="bi bi-patch-check-fill"></i> Aktif</span>
                                <?php elseif($book->status_verifikasi == 'pending'): ?>
                                    <span class="text-warning small fw-semibold"><i class="bi bi-clock-history"></i> Review</span>
                                <?php else: ?>
                                    <span class="text-danger small fw-semibold"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('author.books.edit', $book->id)); ?>"
                                   class="btn btn-sm btn-light text-secondary" title="Edit Buku">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Anda belum mengunggah buku apapun.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/author/dashboard.blade.php ENDPATH**/ ?>
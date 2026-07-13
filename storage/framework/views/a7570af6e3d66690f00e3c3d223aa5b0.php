

<?php $__env->startSection('title', 'Dashboard Penulis'); ?>
<?php $__env->startSection('page-title', 'Dashboard Penulis'); ?>

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

    
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#E0E7FF; color:var(--color-ink);"><i class="bi bi-collection"></i></div>
                <div>
                    <div class="stat-value"><?php echo e($stats['total']); ?></div>
                    <div class="stat-label">Total Buku</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-patch-check"></i></div>
                <div>
                    <div class="stat-value"><?php echo e($stats['verified']); ?></div>
                    <div class="stat-label">Diverifikasi</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#FEE2E2; color:#991B1B;"><i class="bi bi-eye"></i></div>
                <div>
                    <div class="stat-value"><?php echo e(number_format($stats['views'])); ?></div>
                    <div class="stat-label">Total Dibaca</div>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($stats['rejected'] > 0): ?>
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>Anda memiliki <strong><?php echo e($stats['rejected']); ?></strong> buku yang ditolak admin. Periksa alasan penolakan di daftar buku.</span>
    </div>
    <?php endif; ?>

    
    <div class="card-digibaca">
        <div class="card-header-custom">
            <span><i class="bi bi-clock-history me-2"></i>Buku Terbaru Anda</span>
            <a href="<?php echo e(route('author.books.index')); ?>" class="small">Kelola Buku Saya</a>
        </div>
        <div class="table-responsive">
            <table class="table table-digibaca mb-0">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Kategori</th>
                        <th>Akses</th>
                        <th>Status</th>
                        <th>Dibaca</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?php echo e($book->cover_url); ?>" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                                <span class="fw-semibold"><?php echo e(Str::limit($book->judul, 30)); ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?php echo e($book->category->nama_kategori ?? '-'); ?></td>
                        <td>
                            <span class="badge <?php echo e($book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis'); ?>" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                                <?php echo e(ucfirst($book->jenis_akses)); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge-status-<?php echo e($book->status_verifikasi); ?>"><?php echo e(ucfirst($book->status_verifikasi)); ?></span>
                        </td>
                        <td><?php echo e(number_format($book->views)); ?></td>
                        <td>
                            <a href="<?php echo e(route('author.books.edit', $book->id)); ?>" class="btn btn-sm btn-outline-digibaca" title="Edit Buku">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state py-4 text-center text-muted">
                                <i class="bi bi-collection fs-2 mb-2 d-block"></i>
                                <p class="mb-0">Belum ada buku yang diupload.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="<?php echo e(route('author.books.create')); ?>" class="btn btn-digibaca btn-lg px-4">
            <i class="bi bi-cloud-upload me-2"></i> Upload Buku Baru
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.author', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/author/dashboard.blade.php ENDPATH**/ ?>
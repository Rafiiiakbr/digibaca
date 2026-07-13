

<?php $__env->startSection('title', 'Buku Saya'); ?>
<?php $__env->startSection('page-title', 'Buku Saya'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Kelola semua buku yang telah Anda upload.</p>
    <a href="<?php echo e(route('author.books.create')); ?>" class="btn btn-digibaca">
        <i class="bi bi-plus-lg me-1"></i> Upload Buku Baru
    </a>
</div>


<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Format</th>
                    <th>Kategori</th>
                    <th>Akses</th>
                    <th>Usia Min.</th>
                    <th>Status</th>
                    <th>Dibaca</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if($book->cover): ?>
                                <img src="<?php echo e(asset('storage/' . $book->cover)); ?>" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            <?php else: ?>
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width:36px; height:48px;">
                                    <i class="bi bi-book text-white" style="font-size: 0.8rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-semibold"><?php echo e(Str::limit($book->judul, 35)); ?></div>
                                <?php if($book->isbn): ?>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">ISBN: <?php echo e($book->isbn); ?></small>
                                <?php endif; ?>
                                <?php if($book->status_verifikasi == 'rejected' && $book->alasan_penolakan): ?>
                                    <div class="text-danger small" style="font-size: 0.75rem;"><i class="bi bi-exclamation-circle"></i> Ditangguhkan: <?php echo e(Str::limit($book->alasan_penolakan, 40)); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?php echo e(strtoupper($book->format)); ?></span></td>
                    <td class="text-muted"><?php echo e($book->category->nama_kategori ?? '-'); ?></td>
                    <td>
                        <span class="badge <?php echo e($book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis'); ?>" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                            <?php echo e(ucfirst($book->jenis_akses)); ?>

                        </span>
                    </td>
                    <td><?php echo e($book->minimal_usia > 0 ? $book->minimal_usia . '+' : 'Semua Usia'); ?></td>
                    <td><span class="badge-status-<?php echo e($book->status_verifikasi); ?>"><?php echo e(ucfirst($book->status_verifikasi)); ?></span></td>
                    <td><?php echo e(number_format($book->views)); ?></td>
                    <td class="text-end pe-4">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="<?php echo e(route('author.books.edit', $book->id)); ?>" class="btn btn-sm btn-outline-digibaca" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('author.books.destroy', $book->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini? Tindakan tidak dapat dibatalkan.')">
                                <?php echo csrf_field(); ?> 
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8">
                        <div class="empty-state py-5 text-center">
                            <i class="bi bi-collection fs-1 mb-2 d-block text-muted"></i>
                            <h5>Belum ada buku</h5>
                            <p class="text-muted small">Mulai bagikan karya Anda kepada pembaca digital.</p>
                            <a href="<?php echo e(route('author.books.create')); ?>" class="btn btn-digibaca btn-sm mt-2">Upload Buku Pertama</a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center"><?php echo e($books->links()); ?></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.author', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/author/books/index.blade.php ENDPATH**/ ?>
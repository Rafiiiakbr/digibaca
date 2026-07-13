


<?php $__env->startSection('title', 'Kelola Buku'); ?>
<?php $__env->startSection('page-title', 'Kelola Buku'); ?>

<?php $__env->startSection('content'); ?>

<div class="card-digibaca p-3 mb-4">
    <form method="GET" action="<?php echo e(route('admin.books.index')); ?>" class="d-flex gap-2">
        <select name="status" class="form-select" data-auto-submit style="max-width:220px;">
            <option value="">Semua Status</option>
            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu Verifikasi</option>
            <option value="verified" <?php echo e(request('status') == 'verified' ? 'selected' : ''); ?>>Terverifikasi</option>
            <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
        </select>
    </form>
</div>

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Akses</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?php echo e($book->cover_url); ?>" style="width:36px;height:48px;object-fit:cover;border-radius:4px;" alt="">
                            <span class="fw-semibold"><?php echo e(Str::limit($book->judul, 30)); ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($book->author->nama ?? '-'); ?></td>
                    <td class="text-muted"><?php echo e($book->category->nama_kategori ?? '-'); ?></td>
                    <td>
                        <span class="badge <?php echo e($book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis'); ?>" style="position:static; padding:0.3rem 0.6rem; font-size:0.7rem;">
                            <?php echo e(ucfirst($book->jenis_akses)); ?>

                        </span>
                    </td>
                    <td><span class="badge-status-<?php echo e($book->status_verifikasi); ?>"><?php echo e(ucfirst($book->status_verifikasi)); ?></span></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" target="_blank" class="btn btn-sm btn-outline-digibaca me-1" title="Lihat"><i class="bi bi-eye"></i></a>

                        <?php if($book->status_verifikasi !== 'verified'): ?>
                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#verifyModal<?php echo e($book->id); ?>" title="Verifikasi">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <?php endif; ?>

                        <?php if($book->status_verifikasi !== 'rejected'): ?>
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($book->id); ?>" title="Tolak">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <?php endif; ?>

                        <form action="<?php echo e(route('admin.books.destroy', $book->id)); ?>" method="POST" class="d-inline" data-confirm="Hapus buku ini secara permanen?">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                
                <div class="modal fade" id="verifyModal<?php echo e($book->id); ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?php echo e(route('admin.books.verify', $book->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="verified">
                                <div class="modal-header">
                                    <h6 class="modal-title">Verifikasi Buku</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Verifikasi buku <strong><?php echo e($book->judul); ?></strong>? Buku akan tampil di katalog publik.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="modal fade" id="rejectModal<?php echo e($book->id); ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?php echo e(route('admin.books.verify', $book->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="rejected">
                                <div class="modal-header">
                                    <h6 class="modal-title">Tolak Buku</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tolak buku <strong><?php echo e($book->judul); ?></strong>. Berikan alasan penolakan:</p>
                                    <textarea name="alasan_penolakan" class="form-control form-control-digibaca" rows="3" required placeholder="cth: Cover tidak sesuai, file tidak dapat dibuka, dll."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Tolak Buku</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6"><div class="empty-state"><i class="bi bi-journal-x"></i><p class="mb-0">Tidak ada buku ditemukan.</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/admin/books/index.blade.php ENDPATH**/ ?>
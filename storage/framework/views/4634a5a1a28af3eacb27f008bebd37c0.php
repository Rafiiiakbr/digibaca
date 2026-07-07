
<?php $__env->startSection('title', 'Dashboard Pembaca'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Eksplorasi Buku</h2>
            <p class="text-muted mb-0">Temukan bacaan menarik hari ini sesuai minat Anda.</p>
        </div>
        <div class="col-auto">
            <?php if(!Auth::user()->status_premium): ?>
                <a href="<?php echo e(route('reader.premium.index')); ?>" class="btn btn-warning fw-semibold shadow-sm text-dark">
                    <i class="bi bi-lightning-charge-fill"></i> Upgrade Premium
                </a>
            <?php else: ?>
                <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                    <i class="bi bi-crown-fill me-1"></i> Member Premium
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-3"><i class="bi bi-sparkles text-primary"></i> Buku Terbaru</h4>
            <div class="row g-3">
                <?php $__empty_1 = true; $__currentLoopData = $buku_terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-6">
                        <div class="card h-100 d-flex flex-row overflow-hidden">
                            <div class="bg-light d-flex align-items-center justify-content-center border-end" style="width: 100px; min-height: 140px;">
                                <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                            </div>
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex gap-1 mb-1">
                                        <span class="badge bg-primary px-2 py-0.5 text-uppercase" style="font-size: 0.65rem;"><?php echo e($buku->format); ?></span>
                                        <?php if($buku->jenis_akses == 'premium'): ?>
                                            <span class="badge bg-warning text-dark px-2 py-0.5" style="font-size: 0.65rem;"><i class="bi bi-crown-fill"></i> PRO</span>
                                        <?php endif; ?>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-truncate-2"><?php echo e($buku->judul); ?></h6>
                                    <small class="text-muted d-block mb-2"><?php echo e($buku->genre ?? 'Umum'); ?></small>
                                </div>
                                <a href="<?php echo e(route('reader.read', $buku->id)); ?>" class="btn btn-sm btn-outline-primary w-100">Baca</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12"><p class="text-muted">Belum ada buku yang tersedia.</p></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <h4 class="fw-bold mb-3"><i class="bi bi-bookmark-star text-primary"></i> Bookmark Terakhir</h4>
            <div class="card p-3 mb-4">
                <ul class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $last_bookmarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div class="text-truncate me-2">
                                <strong class="d-block text-truncate small"><?php echo e($bookmark->book->judul); ?></strong>
                                <small class="text-muted">Halaman / Letak: <?php echo e($bookmark->halaman); ?></small>
                            </div>
                            <a href="<?php echo e(route('reader.read', $bookmark->book_id)); ?>"
                               class="btn btn-sm btn-light text-primary flex-shrink-0" title="Lanjutkan Membaca">
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item px-0 py-2 text-muted small">Belum ada halaman yang ditandai.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <h4 class="fw-bold mb-3"><i class="bi bi-sticky text-primary"></i> Catatan Terbaru</h4>
            <div class="card p-3">
                <?php $__empty_1 = true; $__currentLoopData = $last_notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="mb-2 pb-2 border-bottom last-border-0">
                        <span class="fw-bold small d-block"><?php echo e($note->book->judul); ?></span>
                        <p class="text-muted small mb-0 text-truncate"><?php echo e($note->isi_catatan); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted small mb-0">Belum ada catatan pribadi yang dibuat.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/reader/dashboard.blade.php ENDPATH**/ ?>
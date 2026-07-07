
<?php $__env->startSection('title', 'Panel Kontrol Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Ringkasan Sistem</h2>
        <p class="text-muted mb-0">Panel kendali metrik pertumbuhan data dan modul verifikasi.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-primary border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL PEMBACA</span>
                <h3 class="fw-bold mb-0 text-primary"><?php echo e($total_user); ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-success border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL PENULIS</span>
                <h3 class="fw-bold mb-0 text-success"><?php echo e($total_author); ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-info border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL BUKU</span>
                <h3 class="fw-bold mb-0 text-info"><?php echo e($total_buku); ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-warning border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">PREMIUM MEMBERS</span>
                <h3 class="fw-bold mb-0 text-warning"><?php echo e($total_premium_user); ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Antrean Verifikasi Buku</h5>
                    <span class="badge bg-danger rounded-pill"><?php echo e($buku_pending); ?> Perlu Review</span>
                </div>
                <div class="text-muted small">
                    <p>Fungsionalitas persetujuan (approval) penuh dan penolakan buku akan diintegrasikan pada modul CRUD manajemen admin selanjutnya.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Transaksi Premium Terbaru</h5>
                <ul class="list-group list-group-flush small">
                    <?php $__empty_1 = true; $__currentLoopData = $recent_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold d-block"><?php echo e($payment->user->nama); ?></span>
                                <small class="text-muted"><?php echo e($payment->created_at->diffForHumans()); ?></small>
                            </div>
                            <span class="badge <?php echo e($payment->status == 'success' ? 'bg-success-subsub' : 'bg-secondary'); ?> text-success fw-bold">
                                Rp <?php echo e(number_format($payment->nominal, 0, ',', '.')); ?>

                            </span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item px-0 py-3 text-center text-muted">Belum ada riwayat transaksi masuk.</li>
                    <?php endif; ?>
                </ul>
                <div class="mt-3 pt-2 border-top bg-light p-2 rounded text-center">
                    <small class="text-muted">Total Dana Likuid: </small>
                    <strong class="text-success">Rp <?php echo e(number_format($total_pendapatan, 0, ',', '.')); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>

 
<?php $__env->startSection('title', 'Daftar Akun'); ?>
 
<?php $__env->startSection('content'); ?>
    <h2 class="font-display mb-1">Buat Akun Baru</h2>
    <p class="text-muted mb-4">Gratis selamanya untuk membaca koleksi buku publik.</p>
 
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
 
    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" class="form-control form-control-digibaca" placeholder="Nama Anda" required autofocus>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Alamat Email</label>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control form-control-digibaca" placeholder="nama@email.com" required>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir')); ?>" class="form-control form-control-digibaca" max="<?php echo e(now()->subYears(5)->format('Y-m-d')); ?>" required>
            <small class="text-muted">Digunakan untuk verifikasi batas usia konten tertentu.</small>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Daftar Sebagai</label>
            <div class="d-flex gap-2">
                <label class="border rounded-3 p-3 flex-fill text-center" style="cursor:pointer;">
                    <input type="radio" name="role" value="reader" class="form-check-input d-block mx-auto mb-1" <?php echo e(old('role', 'reader') == 'reader' ? 'checked' : ''); ?>>
                    <i class="bi bi-book d-block fs-4 mb-1"></i>
                    <span class="small fw-semibold">Pembaca</span>
                </label>
                <label class="border rounded-3 p-3 flex-fill text-center" style="cursor:pointer;">
                    <input type="radio" name="role" value="author" class="form-check-input d-block mx-auto mb-1" <?php echo e(old('role') == 'author' ? 'checked' : ''); ?>>
                    <i class="bi bi-pencil-square d-block fs-4 mb-1"></i>
                    <span class="small fw-semibold">Penulis</span>
                </label>
            </div>
        </div>
 
        <div class="mb-3">
            <label class="form-label fw-semibold small">Password</label>
            <input type="password" name="password" class="form-control form-control-digibaca" placeholder="Minimal 8 karakter" required>
        </div>
 
        <div class="mb-4">
            <label class="form-label fw-semibold small">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control form-control-digibaca" placeholder="Ulangi password" required>
        </div>
 
        <button type="submit" class="btn btn-digibaca w-100 mb-3">Daftar Sekarang</button>
 
        <p class="text-center small text-muted">
            Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="fw-semibold">Masuk di sini</a>
        </p>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/auth/register.blade.php ENDPATH**/ ?>
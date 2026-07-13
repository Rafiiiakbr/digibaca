<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Penulis'); ?> — DigiBaca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="sidebar-digibaca" id="sidebar">
        <a href="<?php echo e(route('home')); ?>" class="sidebar-brand">
            <span class="mark"><i class="bi bi-book"></i></span> DigiBaca
        </a>
        <nav class="py-2">
            <div class="nav-section-label">Menu Penulis</div>
            <a href="<?php echo e(route('author.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('author.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="<?php echo e(route('author.books.index')); ?>" class="nav-link <?php echo e(request()->routeIs('author.books.index') ? 'active' : ''); ?>">
                <i class="bi bi-collection"></i> Buku Saya
            </a>
            <a href="<?php echo e(route('author.books.create')); ?>" class="nav-link <?php echo e(request()->routeIs('author.books.create') ? 'active' : ''); ?>">
                <i class="bi bi-cloud-upload"></i> Upload Buku Baru
            </a>
 
            <div class="nav-section-label">Akun</div>
            <a href="<?php echo e(route('reader.profile')); ?>" class="nav-link"><i class="bi bi-person-circle"></i> Profil</a>
        </nav>
        <div class="sidebar-user">
            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="">
            <div>
                <div class="name"><?php echo e(Str::limit(auth()->user()->nama, 16)); ?></div>
                <div class="role">Penulis</div>
            </div>
        </div>
    </div>
 
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div>
                <button class="btn btn-sm btn-light d-lg-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold"><?php echo $__env->yieldContent('page-title', 'Dashboard Penulis'); ?></span>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm btn-outline-digibaca"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
            </form>
        </div>
 
        <?php if(session('success')): ?>
            <div class="alert alert-success shadow-sm"><i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger shadow-sm"><i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('error')); ?></div>
        <?php endif; ?>
 
        <?php echo $__env->yieldContent('content'); ?>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\buku-digital\resources\views/layouts/author.blade.php ENDPATH**/ ?>
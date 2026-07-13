<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — DigiBaca</title>
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
            <div class="nav-section-label">Menu Pembaca</div>
            <a href="<?php echo e(route('reader.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="<?php echo e(route('books.index')); ?>" class="nav-link">
                <i class="bi bi-search"></i> Cari Buku
            </a>
            <a href="<?php echo e(route('reader.collection')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.collection') ? 'active' : ''); ?>">
                <i class="bi bi-bookmark-heart"></i> Koleksi Saya
            </a>
            <a href="<?php echo e(route('reader.bookmarks')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.bookmarks') ? 'active' : ''); ?>">
                <i class="bi bi-bookmark-star"></i> Bookmark
            </a>
            <a href="<?php echo e(route('reader.notes')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.notes') ? 'active' : ''); ?>">
                <i class="bi bi-journal-text"></i> Catatan
            </a>
            <a href="<?php echo e(route('reader.history')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.history') ? 'active' : ''); ?>">
                <i class="bi bi-clock-history"></i> Riwayat Baca
            </a>
 
            <div class="nav-section-label">Akun</div>
            <a href="<?php echo e(route('reader.profile')); ?>" class="nav-link <?php echo e(request()->routeIs('reader.profile') ? 'active' : ''); ?>">
                <i class="bi bi-person-circle"></i> Profil
            </a>
            <?php if(!auth()->user()->isPremium()): ?>
            <a href="<?php echo e(route('premium.upgrade')); ?>" class="nav-link" style="color: var(--color-amber);">
                <i class="bi bi-gem"></i> Upgrade Premium
            </a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-user">
            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="">
            <div>
                <div class="name"><?php echo e(Str::limit(auth()->user()->nama, 16)); ?></div>
                <div class="role"><?php echo e(auth()->user()->isPremium() ? 'Member Premium' : 'Member Gratis'); ?></div>
            </div>
        </div>
    </div>
 
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div>
                <button class="btn btn-sm btn-light d-lg-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></span>
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
        <?php if(session('info')): ?>
            <div class="alert alert-info shadow-sm"><i class="bi bi-info-circle-fill me-2"></i><?php echo e(session('info')); ?></div>
        <?php endif; ?>
 
        <?php echo $__env->yieldContent('content'); ?>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\buku-digital\resources\views/layouts/reader.blade.php ENDPATH**/ ?>
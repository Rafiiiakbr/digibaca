<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Pustaka Digital'); ?> - ReadOn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/mixins/_box-shadow.scss" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; color: #0d6efd; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('landing')); ?>"><i class="bi bi-book-half"></i> ReadOn</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-span"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item me-3">
                            <span class="badge bg-secondary text-capitalize">Role: <?php echo e(Auth::user()->role); ?></span>
                            <?php if(Auth::user()->status_premium): ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-crown-fill"></i> Premium</span>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-light px-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> Halo, <?php echo e(Auth::user()->nama); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <?php if(Auth::user()->role == 'admin'): ?>
                                        <a class="dropdown-menu-item dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard Admin</a>
                                    <?php elseif(Auth::user()->role == 'author'): ?>
                                        <a class="dropdown-menu-item dropdown-item" href="<?php echo e(route('author.dashboard')); ?>">Dashboard Penulis</a>
                                    <?php else: ?>
                                        <a class="dropdown-menu-item dropdown-item" href="<?php echo e(route('reader.dashboard')); ?>">Dashboard Baca</a>
                                    <?php endif; ?>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Masuk</a></li>
                        <li class="nav-item"><a class="btn btn-primary ms-2 px-4" href="<?php echo e(route('register')); ?>">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>

    <main class="py-2">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\buku-digital\resources\views/layouts/app.blade.php ENDPATH**/ ?>
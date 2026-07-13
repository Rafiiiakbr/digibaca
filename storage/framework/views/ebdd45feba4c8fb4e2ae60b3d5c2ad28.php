
 
<?php $__env->startSection('title', 'Beranda'); ?>
 
<?php
    $latestBooks = \App\Models\Book::verified()->with(['author','category'])->latest()->take(8)->get();
    $popularBooks = \App\Models\Book::verified()->with(['author','category'])->orderByDesc('views')->take(4)->get();
    $categories = \App\Models\Category::withCount('verifiedBooks')->orderByDesc('books_count')->take(8)->get();
?>
 
<?php $__env->startSection('content'); ?>
 

<section class="bg-ink position-relative overflow-hidden" style="padding: 5rem 0 7rem;">
    <div class="position-absolute" style="width:600px;height:600px;background:radial-gradient(circle,rgba(245,158,11,0.15),transparent 70%);top:-200px;right:-200px;"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background:rgba(245,158,11,0.15); color:var(--color-amber); font-size:0.8rem; font-weight:600;">
                    <i class="bi bi-stars me-1"></i> Perpustakaan digital generasi baru
                </span>
                <h1 class="font-display text-white mb-3" style="font-size: 2.8rem; line-height:1.15;">
                    Setiap halaman,<br>setiap saat, <span class="text-amber">di tanganmu.</span>
                </h1>
                <p class="text-white-50 mb-4 fs-5">
                    Baca ribuan buku PDF dan ePub langsung dari peramban — tanpa unduh, tanpa ribet. Gratis untuk mulai, premium untuk lebih banyak pilihan.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-amber btn-lg px-4">
                        <i class="bi bi-search me-1"></i> Jelajahi Katalog
                    </a>
                    <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-lg px-4" style="background:transparent;border:1.5px solid rgba(255,255,255,0.3);color:#fff;">
                        Daftar Gratis
                    </a>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-4 mt-5">
                    <div>
                        <div class="fs-3 fw-bold text-white font-display"><?php echo e(\App\Models\Book::verified()->count()); ?>+</div>
                        <div class="small text-white-50">Judul Tersedia</div>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold text-white font-display"><?php echo e(\App\Models\User::where('role','author')->count()); ?>+</div>
                        <div class="small text-white-50">Penulis Aktif</div>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold text-white font-display"><?php echo e(\App\Models\User::where('role','reader')->count()); ?>+</div>
                        <div class="small text-white-50">Pembaca</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-flex gap-3 justify-content-center" style="transform: rotate(-3deg);">
                    <?php $__currentLoopData = $latestBooks->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-3 overflow-hidden shadow-lg" style="width:160px; aspect-ratio:3/4; margin-top: <?php echo e($i == 1 ? '-2rem' : '1rem'); ?>; background:linear-gradient(135deg,#ece9f7,#ddd8f0);">
                            <img src="<?php echo e($book->cover_url); ?>" class="w-100 h-100" style="object-fit:cover;" alt="<?php echo e($book->judul); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
 

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-eyebrow">Jelajahi</span>
                <h2 class="font-display mb-0">Kategori Populer</h2>
            </div>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-digibaca btn-sm">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-3">
                <a href="<?php echo e(route('books.index', ['kategori' => $cat->id])); ?>" class="text-decoration-none">
                    <div class="card-digibaca p-3 text-center h-100" style="transition:0.2s;">
                        <i class="bi <?php echo e($cat->icon ?? 'bi-book'); ?> fs-2 mb-2" style="color: var(--color-ink);"></i>
                        <div class="fw-semibold small" style="color: var(--color-text);"><?php echo e($cat->nama_kategori); ?></div>
                        <div class="text-muted" style="font-size:0.75rem;"><?php echo e($cat->books_count); ?> buku</div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
 

<section class="py-5" style="background: var(--color-surface);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-eyebrow">Baru Diterbitkan</span>
                <h2 class="font-display mb-0">Rilis Terbaru</h2>
            </div>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-digibaca btn-sm">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $latestBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-3">
                <?php echo $__env->make('public.partials.book-card', ['book' => $book], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
 

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-eyebrow">Banyak Dibaca</span>
                <h2 class="font-display mb-0">Sedang Populer</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $popularBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-6">
                <?php echo $__env->make('public.partials.book-card', ['book' => $book], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
 

<section class="py-5">
    <div class="container">
        <div class="rounded-4 p-5 d-flex flex-wrap align-items-center justify-content-between gap-4" style="background: linear-gradient(120deg, var(--color-ink), var(--color-ink-light));">
            <div>
                <h3 class="font-display text-white mb-2">Punya karya yang ingin dibagikan?</h3>
                <p class="text-white-50 mb-0" style="max-width:480px;">Daftar sebagai penulis, unggah buku Anda dalam format PDF atau ePub, dan jangkau ribuan pembaca digital.</p>
            </div>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-amber btn-lg px-4">Mulai Menulis <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>
 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/public/landing.blade.php ENDPATH**/ ?>
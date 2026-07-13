<?php
    // Usage: @include('public.partials.book-card', ['book' => $book])
?>
<div class="book-card">
    <a href="<?php echo e(route('books.show', $book->id)); ?>" class="text-decoration-none">
        <div class="cover-wrap">
            <img src="<?php echo e($book->cover_url); ?>" alt="<?php echo e($book->judul); ?>" loading="lazy">
            <span class="badge-akses <?php echo e($book->jenis_akses == 'premium' ? 'badge-premium' : 'badge-gratis'); ?>">
                <?php echo e($book->jenis_akses == 'premium' ? 'Premium' : 'Gratis'); ?>

            </span>
            <?php if($book->minimal_usia > 0): ?>
                <span class="badge-akses badge-usia" style="top:42px;"><?php echo e($book->minimal_usia); ?>+</span>
            <?php endif; ?>
        </div>
    </a>
    <div class="card-body-custom">
        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="text-decoration-none">
            <div class="book-title"><?php echo e($book->judul); ?></div>
        </a>
        <div class="book-author"><?php echo e($book->author->nama ?? 'Anonim'); ?></div>
        <div class="book-meta">
            <span><i class="bi bi-tag"></i> <?php echo e($book->category->nama_kategori ?? '-'); ?></span>
            <span><i class="bi bi-eye"></i> <?php echo e(number_format($book->views)); ?></span>
        </div>
    </div>
</div><?php /**PATH C:\buku-digital\resources\views/public/partials/book-card.blade.php ENDPATH**/ ?>
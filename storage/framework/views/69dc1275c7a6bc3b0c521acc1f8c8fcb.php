
 
<?php $__env->startSection('title', 'Upload Buku Baru'); ?>
<?php $__env->startSection('page-title', 'Upload Buku Baru'); ?>
 
<?php $__env->startSection('content'); ?>
 
<div class="card-digibaca p-4">
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
 
    <form method="POST" action="<?php echo e(route('author.books.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('author.books._form', ['book' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-digibaca px-4"><i class="bi bi-cloud-upload me-1"></i> Upload Buku</button>
            <a href="<?php echo e(route('author.books.index')); ?>" class="btn btn-light px-4">Batal</a>
        </div>
    </form>
</div>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.author', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\buku-digital\resources\views/author/books/create.blade.php ENDPATH**/ ?>
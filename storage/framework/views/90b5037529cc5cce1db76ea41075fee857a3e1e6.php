<?php $__env->startSection('title', 'Error 404'); ?>

<?php $__env->startSection('page-style'); ?>
        
        <link rel="stylesheet" href="<?php echo e(asset(mix('css/pages/error.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- error 404 -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
    <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
      <div class="card-content">
        <div class="card-body text-center">
          <img src="<?php echo e(asset('images/pages/404.png')); ?>" class="img-fluid align-self-center" alt="branding logo">
          <h1 class="font-large-2 my-1">Halaman Tidak Ditemukan!</h1>
          <p class="p-2">
              Maaf, halaman yang anda tuju tidak dapat ditemukan (error 404).
          </p>
          <a class="btn btn-primary btn-lg mt-2" href="#" onclick="javascript:window.history.back();">Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- error 404 end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/error-404.blade.php ENDPATH**/ ?>
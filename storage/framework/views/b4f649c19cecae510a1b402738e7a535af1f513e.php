<?php $__env->startSection('title', 'Maintenance'); ?>

<?php $__env->startSection('page-style'); ?>
        
        <link rel="stylesheet" href="<?php echo e(asset(mix('css/pages/coming-soon.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- coming soon flat design -->
<section>
  <div class="row d-flex vh-100 align-items-center justify-content-center">
    <div class="col-xl-5 col-md-8 col-sm-10 col-12 px-md-0 px-2">
        <div class="card text-center w-100 mb-0">
            <div class="card-header justify-content-center pb-0">
                <div class="card-title">
                    <h2 class="mb-0">Mohon maaf, akses kami tutup dari jam 00:00 WITA sampai dengan jam 06:00 WITA.</h2>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body pt-0">
                    <img src="<?php echo e(asset('images/pages/rocket.png')); ?>" class="img-responsive block width-150 mx-auto" width="150" alt="bg-img">
                    <div id="clockFlat" class="card-text text-center getting-started pt-2 d-flex justify-content-center flex-wrap"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
<!--/ coming soon flat design -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-script'); ?>
        
        <script src="<?php echo e(asset(mix('vendors/js/coming-soon/jquery.countdown.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
        
        <script src="<?php echo e(asset(mix('js/scripts/maintenance.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/maintenance.blade.php ENDPATH**/ ?>
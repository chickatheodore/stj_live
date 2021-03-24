<?php $__env->startSection('title', 'Transfer PIN'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <!-- vendor css files -->
    <link rel='stylesheet' href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/sweetalert2.min.css'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/toastr.css'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-style'); ?>
    <!-- Page css files -->
    <link rel="stylesheet" href="<?php echo e(asset(mix('css/plugins/extensions/toastr.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" id="form-transfer-pin" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Transfer PIN</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="member_id">Transfer ke Member</label>
                                                <select class="form-control member_id" id="member_id" name="member_id">
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($currMember->id); ?>"><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <hr />

                                            <div class="form-group">
                                                <label for="amount">Jumlah PIN yang akan ditransfer</label>
                                                <input type="number" class="form-control touchspin-min-max" id="amount" name="amount" value="0">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <button type="submit" id="btn-save" class="btn btn-primary float-right btn-inline mb-50" disabled>Transfer PIN</button>
                                    <input type="hidden" id="_acc_" name="_acc_" value="<?php echo e(auth()->id()); ?>">
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
    <!-- vendor files -->
    <script src="<?php echo e(asset(mix('vendors/js/forms/select/select2.full.min.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/extensions/sweetalert2.all.min.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/extensions/toastr.min.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <!-- Page js files -->

    <script type="text/javascript">
        var mySelf = <?php echo e($member->id); ?>;
        var counterMin = 0;
        var counterMax = <?php echo e($member->pin); ?>;
    </script>

    <script src="<?php echo e(asset(mix('js/scripts/members/transfer-pin.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/members/transfer-pin.blade.php ENDPATH**/ ?>
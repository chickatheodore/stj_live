<?php $__env->startSection('title', 'Penempatan'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <!-- vendor css files -->
    <link rel='stylesheet' href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/sweetalert2.min.css'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/toastr.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-style'); ?>
    <!-- Page css files -->
    <link rel="stylesheet" href="<?php echo e(asset(mix('css/plugins/extensions/toastr.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php
$read_only = isset($saved) || count($newMembers) < 1;
?>

<?php $__env->startSection('content'); ?>
    <style>
        .custom-radio {
            width: 100px;
            display: inline-block;
            margin: 5px;
        }
        .custom-radio label {
            display: block;
            text-align: center;
            width: 100px;
        }
        .custom-radio input {
            width: 20px;
            display: block;
            margin: 0px auto;
        }
    </style>
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" method="POST" action="<?php echo e(route('member.placement')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Penempatan Member</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="member_id">Member Baru</label>
                                                <select class="form-control sponsor_id" id="member_id" name="member_id" <?php echo e($read_only ? 'disabled' : ''); ?>>
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $newMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($saved)): ?>
                                                            <?php if($member->id == $currMember->id): ?>
                                                    <option value="<?php echo e($currMember->id); ?>" selected><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                    <option value="<?php echo e($currMember->id); ?>"><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <hr />

                                            <div class="form-group">
                                                <label for="sponsor_id">Sponsor</label>
                                                <select class="form-control sponsor_id" id="sponsor_id" name="sponsor_id" <?php echo e($read_only ? 'disabled' : ''); ?>>
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($saved)): ?>
                                                            <?php if($member->sponsor_id == $currMember->id): ?>
                                                    <option value="<?php echo e($currMember->id); ?>" selected><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                    <option value="<?php echo e($currMember->id); ?>"><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="upline_id">Upline</label>
                                                <select class="form-control upline_id" id="upline_id" name="upline_id" <?php echo e($read_only ? 'disabled' : ''); ?>>
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($saved)): ?>
                                                            <?php if($member->upline_id == $currMember->id): ?>
                                                    <option value="<?php echo e($currMember->id); ?>" selected><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                    <option value="<?php echo e($currMember->id); ?>"><?php echo e($currMember->code); ?> - <?php echo e($currMember->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-label-group pohon">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-inline-block">
                                                        <fieldset>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="pohonRadio" id="pohonKiri" value="left" disabled>
                                                                <label class="custom-control-label" for="pohonKiri" id="labelKiri">
                                                                    <?php if(isset($saved)): ?>
                                                                        <?php if($member->upLine): ?>
                                                                            <?php if($member->upLine->leftDownLine() != null): ?>
                                                                    <?php echo e($member->upLine->leftDownLine()->code); ?><br /><?php echo e($member->upLine->leftDownLine()->name); ?>

                                                                            <?php else: ?>
                                                                    A. Tersedia
                                                                            <?php endif; ?>
                                                                        <?php else: ?>
                                                                    A. Tersedia
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                    A. Tersedia
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                    <li class="d-inline-block" style="min-width:20px;">&nbsp;</li>
                                                    <li class="d-inline-block">
                                                        <fieldset>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="pohonRadio" id="pohonKanan" value="right" disabled>
                                                                <label class="custom-control-label" for="pohonKanan" id="labelKanan">
                                                                    <?php if(isset($saved)): ?>
                                                                        <?php if($member->upLine): ?>
                                                                            <?php if($member->upLine->rightDownLine() != null): ?>
                                                                    <?php echo e($member->upLine->rightDownLine()->code); ?><br /><?php echo e($member->upLine->rightDownLine()->name); ?>

                                                                            <?php else: ?>
                                                                    B. Tersedia
                                                                            <?php endif; ?>
                                                                        <?php else: ?>
                                                                    B. Tersedia
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                    B. Tersedia
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_id">Upgrade level member</label>
                                                <select class="form-control level_id" id="level_id" name="level_id" disabled>
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($member->level_id == $level->id && $read_only): ?>
                                                            <option value="<?php echo e($level->id); ?>" selected><?php echo e($level->name); ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo e($level->id); ?>"><?php echo e($level->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <div class="level-hide">Jumlah PIN : 0</div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <button type="submit" id="btn-save" class="btn btn-primary float-right btn-inline mb-50" disabled>Save changes</button>
                                </div>
                            </div>
                            <div class="col-md-3">&nbsp;</div>

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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <!-- Page js files -->
    <script src="<?php echo e(asset(mix('js/scripts/members/placement.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views//members/placement.blade.php ENDPATH**/ ?>
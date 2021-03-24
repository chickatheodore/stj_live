<?php $__env->startSection('title', 'Member Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    
    <section id="member-dashboard">
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        Upline :<br />
                        <?php echo e($member->upLine->name); ?>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        Nama Member :<br />
                        <?php echo e($member->name); ?>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        Member ID :<br />
                        <?php echo e($member->code); ?>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        Tgl berakhir Tutup Poin<br />
                        <?php echo e(Carbon\Carbon::parse($member->close_point_date)->format('d-M-Y')); ?>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        Sisa hari masa berlaku Tutup Poin<br />
                        <?php
                            $dt = Carbon\Carbon::now();
                            $date = Carbon\Carbon::parse($member->close_point_date);
                        ?>
                        <?php echo e($date->diffInDays()); ?> Hari
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        Poin<br />
                        <?php echo e(number_format($member->left_point, 0)); ?> | <?php echo e(number_format($member->right_point, 0)); ?>

                    </div>
                </div>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </section>
    <!-- Dashboard Analytics end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views//members/dashboard.blade.php ENDPATH**/ ?>
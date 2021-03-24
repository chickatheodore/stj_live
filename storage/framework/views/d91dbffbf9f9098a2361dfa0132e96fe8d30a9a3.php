<?php $__env->startSection('title', 'Pohon Sponsor'); ?>

<?php $__env->startSection('content'); ?>
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <?php $__currentLoopData = $sponsors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card">
                            <div class="card-body">
                                <table style="width: 100%; text-align: center">
                                    <tr>
                                        <td><h4>Data Member</h4></td>
                                        <td><h4>Data Upline</h4></td>
                                    </tr>
                                    <tr>
                                        <td><h4><?php echo e($sponsor->username); ?></h4></td>
                                        <td><h4><?php echo e($sponsor->upLine->username); ?></h4></td>
                                    </tr>
                                    <tr>
                                        <td>Member ID : <?php echo e($sponsor->code); ?></td>
                                        <td>Member ID : <?php echo e($sponsor->upLine->code); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/members/sponsor.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'List Stockiest'); ?>

<?php $__env->startSection('content'); ?>
    <section id="stocikest-layout">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-hover table-bordered" style="width: 100%;">
                                    <tr>
                                        <th style="width:30%">Member ID</th>
                                        <th style="width:40%">Nama</th>
                                        <th style="width:30%">No. Telp</th>
                                    </tr>
                                    <?php $__currentLoopData = $stockiests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($member->code); ?></td>
                                            <td><?php echo e($member->name); ?></td>
                                            <td><?php echo e($member->phone); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/members/stockiest.blade.php ENDPATH**/ ?>
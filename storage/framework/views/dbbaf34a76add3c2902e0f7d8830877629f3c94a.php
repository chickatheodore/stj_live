<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0"><?php echo $__env->yieldContent('title'); ?></h2>
                <div class="breadcrumb-wrapper col-12">
                    <?php if(@isset($breadcrumbs)): ?>
                    <ol class="breadcrumb">
                        
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="breadcrumb-item">
                            <?php if(isset($breadcrumb['link'])): ?>
                            <a href="<?php echo e($breadcrumb['link']); ?>">
                                <?php endif; ?>
                                <?php echo e($breadcrumb['name']); ?>

                                <?php if(isset($breadcrumb['link'])): ?>
                            </a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrum-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="feather icon-settings"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\repos\stj\dummy\resources\views/panels/breadcrumb.blade.php ENDPATH**/ ?>
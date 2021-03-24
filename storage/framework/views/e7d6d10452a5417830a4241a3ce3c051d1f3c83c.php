<body
    class="horizontal-layout horizontal-menu <?php echo e($configData['horizontalMenuType']); ?> <?php echo e($configData['blankPageClass']); ?> <?php echo e($configData['bodyClass']); ?>  <?php echo e(($configData['theme'] === 'dark') ? 'dark-layout' : 'light'); ?> <?php echo e($configData['footerType']); ?>  footer-light"
    data-menu="horizontal-menu" data-col="2-columns" data-open="hover" data-layout="<?php echo e($configData['theme']); ?>">

    
    <?php echo $__env->make('panels.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- BEGIN: Header-->
    
    <?php echo $__env->make('panels.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('panels.horizontalMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="modal fade text-left" id="modal-backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div style="text-align: center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div id="loader-text">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(($configData['contentLayout']!=='default') && isset($configData['contentLayout'])): ?>
        <div class="content-area-wrapper">
            <div class="<?php echo e($configData['sidebarPositionClass']); ?>">
                <div class="sidebar">
                    
                    <?php echo $__env->yieldContent('content-sidebar'); ?>
                </div>
            </div>
            <div class="<?php echo e($configData['contentsidebarClass']); ?>">
                <div class="content-wrapper">
                    <div class="content-body">
                        
                        <?php echo $__env->yieldContent('content'); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="content-wrapper">
            
            <?php if($configData['pageHeader'] == true): ?>
            <?php echo $__env->make('panels.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <div class="content-body">

                
                <?php echo $__env->yieldContent('content'); ?>

            </div>
        </div>
        <?php endif; ?>

    </div>
    <!-- End: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    
    <?php echo $__env->make('panels/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('panels/scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html>
<?php /**PATH D:\repos\stj\dummy\resources\views/layouts/horizontalLayoutMaster.blade.php ENDPATH**/ ?>
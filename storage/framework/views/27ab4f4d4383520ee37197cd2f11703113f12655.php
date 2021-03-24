
<ul class="menu-content">
    <?php if(isset($menu)): ?>
    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $submenuTranslation = "";
    if(isset($menu->i18n)){
    $submenuTranslation = $menu->i18n;
    }
    ?>
    <li class="<?php echo e((request()->is($submenu->url)) ? 'active' : ''); ?>">
        <a href="<?php echo e($submenu->url); ?>">
            <i class="<?php echo e(isset($submenu->icon) ? $submenu->icon : ""); ?>"></i>
            <span class="menu-title" data-i18n="<?php echo e($submenuTranslation); ?>"><?php echo e(__('locale.'.$submenu->name)); ?></span>
        </a>
        <?php if(isset($submenu->submenu)): ?>
        <?php echo $__env->make('panels/submenu', ['menu' => $submenu->submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</ul><?php /**PATH D:\repos\stj\dummy\resources\views/panels/submenu.blade.php ENDPATH**/ ?>

<ul class="dropdown-menu">
  <?php if(isset($menu)): ?>
  <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
      $custom_classes = "";
      if(isset($submenu->classlist)) {
          $custom_classes = $submenu->classlist;
      }
      $submenuTranslation = "";
      if(isset($menu->i18n)){
          $submenuTranslation = $menu->i18n;
      }
  ?>
  <li
    class="<?php echo e((request()->is($submenu->url)) ? 'active' : ''); ?> <?php echo e((isset($submenu->submenu)) ? "dropdown dropdown-submenu" : ''); ?> <?php echo e($custom_classes); ?>">
    <a href="<?php echo e($submenu->url); ?>" class="dropdown-item <?php echo e((isset($submenu->submenu)) ? "dropdown-toggle" : ''); ?>"
      <?php echo e((isset($submenu->submenu)) ? 'data-toggle=dropdown' : ''); ?>>
      <i class="<?php echo e(isset($submenu->icon) ? $submenu->icon : ""); ?>"></i>
      <span data-i18n="<?php echo e($submenuTranslation); ?>"><?php echo e(__('locale.'.$submenu->name)); ?></span>
    </a>
    <?php if(isset($submenu->submenu)): ?>
    <?php echo $__env->make('panels/horizontalSubmenu', ['menu' => $submenu->submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
  </li>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
</ul><?php /**PATH D:\repos\stj\dummy\resources\views/panels/horizontalSubmenu.blade.php ENDPATH**/ ?>
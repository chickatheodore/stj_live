<?php
$configData = Helper::applClasses();
?>

<div class="horizontal-menu-wrapper">
  <div
    class="header-navbar navbar-expand-sm navbar navbar-horizontal <?php echo e($configData['horizontalMenuClass']); ?> <?php echo e(($configData['theme'] === 'light') ? "navbar-light" : "navbar-dark"); ?> navbar-without-dd-arrow navbar-shadow navbar-brand-center"
    role="navigation" data-menu="menu-wrapper" data-nav="brand-center">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto"><a class="navbar-brand" href="home">
            <div class="brand-logo"></div>
            <h2 class="brand-text mb-0">STJ</h2>
          </a></li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
            <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
              data-ticon="icon-disc"></i>
          </a>
        </li>
      </ul>
    </div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        
        <?php if(isset($menuData[1])): ?>
        <?php $__currentLoopData = $menuData[1]->menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $custom_classes = "";
        if(isset($menu->classlist)) {
        $custom_classes = $menu->classlist;
        }
        $translation = "";
        if(isset($menu->i18n)){
        $translation = $menu->i18n;
        }
        ?>
        <li class="<?php if(isset($menu->submenu)): ?><?php echo e('dropdown'); ?><?php endif; ?> nav-item <?php echo e((request()->is($menu->url)) ? 'active' : ''); ?> <?php echo e($custom_classes); ?>"
         <?php if(isset($menu->submenu)): ?><?php echo e('data-menu=dropdown'); ?><?php endif; ?>>
          <a href="<?php echo e($menu->url); ?>" class="<?php if(isset($menu->submenu)): ?><?php echo e('dropdown-toggle'); ?><?php endif; ?> nav-link"  <?php if(isset($menu->submenu)): ?><?php echo e('data-toggle=dropdown'); ?><?php endif; ?>>
            <i class="<?php echo e($menu->icon); ?>"></i>
            <span data-i18n="<?php echo e($translation); ?>"><?php echo e(__('locale.'.$menu->name)); ?></span>
          </a>
          <?php if(isset($menu->submenu)): ?>
          <?php echo $__env->make('panels/horizontalSubmenu', ['menu' => $menu->submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</div>
<?php /**PATH D:\repos\stj\dummy\resources\views/panels/horizontalMenu.blade.php ENDPATH**/ ?>
<?php if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"])): ?>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu <?php echo e($configData['navbarColor']); ?> navbar-fixed">
  <div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item"><a class="navbar-brand" href="home">
          <div class="brand-logo"></div>
        </a></li>
    </ul>
  </div>
  <?php else: ?>
  <nav
    class="header-navbar navbar-expand-lg navbar navbar-with-menu <?php echo e($configData['navbarClass']); ?> navbar-light navbar-shadow <?php echo e($configData['navbarColor']); ?>">
    <?php endif; ?>
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="navbar-collapse" id="navbar-mobile">
          <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav">
              <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                  href="#"><i class="ficon feather icon-menu"></i></a></li>
            </ul>
          </div>
          <ul class="nav navbar-nav float-right">
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                  class="ficon feather icon-maximize"></i></a></li>
            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i
                  class="ficon feather icon-search"></i></a>
              <div class="search-input">
                <div class="search-input-icon"><i class="feather icon-search primary"></i></div>
                <input class="input" type="text" placeholder="Explore STJ ..." tabindex="-1"
                  data-search="laravel-search-list" />
                <div class="search-input-close"><i class="feather icon-x"></i></div>
                <ul class="search-list search-list-main"></ul>
              </div>
            </li>
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                data-toggle="dropdown">
                <div class="user-nav d-sm-flex d-none">
                  <?php if(auth()->user() == null): ?>
                  <span class="user-name text-bold-600">Guest</span>
                  <span class="user-status">Available</span>
                  <?php else: ?>
                  <span class="user-name text-bold-600"><?php echo e(auth()->user()->username); ?></span>
                  <span class="user-status"><?php echo e(auth()->user()->code); ?></span>
                  <?php endif; ?>
                </div>
                <span>
                  <img class="round"
                    src="<?php echo e(asset('images/portrait/small/avatar-s-11.jpg')); ?>" alt="avatar" height="40"
                    width="40" />
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile">
                  <i class="feather icon-user"></i> Edit Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout">
                  <i class="feather icon-power"></i> Logout
                </a>
                <form id="logout-form" action="login" method="POST" style="display: none;">
                  <?php echo csrf_field(); ?>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- END: Header-->
<?php /**PATH D:\repos\stj\dummy\resources\views/panels/navbar.blade.php ENDPATH**/ ?>
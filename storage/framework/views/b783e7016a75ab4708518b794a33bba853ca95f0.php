<?php $__env->startSection('title', 'Login Page'); ?>

<?php $__env->startSection('page-style'); ?>

<link rel="stylesheet" href="<?php echo e(asset(mix('css/pages/authentication.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="row flexbox-container">
  <div class="col-xl-8 col-11 d-flex justify-content-center">
    <div class="card bg-authentication rounded-0 mb-0">
      <div class="row m-0">
        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
          <img src="<?php echo e(asset('images/pages/login.png')); ?>" alt="branding logo">
        </div>
        <div class="col-lg-6 col-12 p-0">
          <div class="card rounded-0 mb-0 px-2">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="mb-0">Login</h4>
              </div>
            </div>
            <p class="px-2">Welcome back, please login to your account.</p>
            <div class="card-content">
              <div class="card-body pt-1">
                <?php if(isset($url)): ?>
                <form method="POST" action='<?php echo e(url("$url/login")); ?>'>
                <?php else: ?>
                <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php endif; ?>
                  <?php echo csrf_field(); ?>
                  <fieldset class="form-label-group form-group position-relative has-icon-left">

                    <input id="username" type="number" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="username" placeholder="Member ID" value="<?php echo e(old('username')); ?>" required autocomplete="username"
                      autofocus>

                    <div class="form-control-position">
                      <i class="feather icon-user"></i>
                    </div>
                    <label for="username">Member ID</label>
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </fieldset>

                  <fieldset class="form-label-group position-relative has-icon-left">

                    <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="password" placeholder="Password" required autocomplete="current-password">

                    <div class="form-control-position">
                      <i class="feather icon-lock"></i>
                    </div>
                    <label for="password">Password</label>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </fieldset>
                  <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="text-left">
                      <fieldset class="checkbox">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                          <input type="checkbox" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                          <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                              <i class="vs-icon feather icon-check"></i>
                            </span>
                          </span>
                          <span class="">Remember me</span>
                        </div>
                      </fieldset>
                    </div>
                    <?php if(Route::has('password.request')): ?>
                    <div class="text-right"><a class="card-link" href="<?php echo e(route('password.request')); ?>">
                        Forgot Password?
                      </a></div>
                    <?php endif; ?>

                  </div>
                  <a href="register" class="btn btn-outline-primary float-left btn-inline">Register</a>
                  <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                </form>
              </div>
            </div>

            <div class="login-footer">
              <div class="divider">
                &nbsp;
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/fullLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/auth/login.blade.php ENDPATH**/ ?>
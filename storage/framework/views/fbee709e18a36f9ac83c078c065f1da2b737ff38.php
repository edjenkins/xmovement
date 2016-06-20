<form class="auth-form" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
    <?php echo csrf_field(); ?>


    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <label class="control-label">Email Address</label>

        <input type="email" class="form-control input-field" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email">

        <?php if($errors->has('email')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
        <?php endif; ?>

    </div>

    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
        <label class="control-label">Password</label>

        <input type="password" class="form-control input-field" name="password" placeholder="Password">

        <?php if($errors->has('password')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('password')); ?></strong>
            </span>
        <?php endif; ?>

    </div>

    <div class="form-group visuallyhidden">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>
    </div>

    <div class="form-group">
    
        <button type="submit" class="btn btn-primary">
            Login
        </button>

        <br />
        
        <a class="btn btn-link muted-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a>
    
    </div>
    
    <div class="text-linethru">
        <div class="line"></div>
        <div class="text">or</div>
    </div>

    <div class="form-group">
        <a class="btn btn-facebook" href="<?php echo e(action('Auth\AuthController@redirectToProvider')); ?>">
            <i class="fa fa-fw fa-facebook"></i>
            Log in with Facebook
        </a>
    </div>

</form>
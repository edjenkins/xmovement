<form class="auth-form" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
    <?php echo csrf_field(); ?>


    <input type="hidden" name="type" value="<?php echo e($type); ?>">

    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
        <label class="control-label">Name</label>

        <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="Name">

        <?php if($errors->has('name')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('name')); ?></strong>
            </span>
        <?php endif; ?>

    </div>

    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <label class="control-label">Email Address</label>

        <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email">

        <?php if($errors->has('email')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
        <?php endif; ?>

    </div>

    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
        <label class="control-label">Password</label>

        <input type="password" class="form-control" name="password" placeholder="Password">

        <?php if($errors->has('password')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('password')); ?></strong>
            </span>
        <?php endif; ?>

    </div>

    <?php if($type == 'standard'): ?>

        <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
            <label class="control-label">Confirm Password</label>

            <input type="password" class="form-control" name="password_confirmation" placeholder="Password">

            <?php if($errors->has('password_confirmation')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                </span>
            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="form-group">

        <button type="submit" class="btn btn-primary">
            Register
        </button>

        <?php if($type == 'standard'): ?>

            <br />
            <a class="btn btn-link muted-link" href="<?php echo e(url('/login')); ?>">Already have an account?</a>

        <?php endif; ?>

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

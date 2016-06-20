<nav class="navbar">
    <div class="container">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only"><?php echo e(trans('navbar.toggle')); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <strong><?php echo e(trans('common.brand')); ?></strong>
            </a>

            <div class="clearfix"></div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo e(action('IdeaController@add')); ?>"><?php echo e(trans('navbar.create')); ?></a></li>
            
                <li><a href="<?php echo e(action('IdeaController@index')); ?>"><?php echo e(trans('navbar.explore')); ?></a></li>
            
                <li><a href="<?php echo e(action('PageController@about')); ?>"><?php echo e(trans('navbar.about')); ?></a></li>

                <?php if(Auth::guest()): ?>
                    <li><a href="<?php echo e(action('Auth\AuthController@showLoginForm')); ?>"><?php echo e(trans('navbar.login')); ?></a></li>
                    <li><a href="<?php echo e(action('Auth\AuthController@showRegistrationForm')); ?>"><?php echo e(trans('navbar.register')); ?></a></li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo e(action('UserController@profile')); ?>"></i><?php echo e(trans('navbar.profile')); ?></a></li>
                            <li><a href="<?php echo e(action('Auth\AuthController@logout')); ?>"></i><?php echo e(trans('navbar.logout')); ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
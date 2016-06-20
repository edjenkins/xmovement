<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>XM</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Styles -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo e(URL::asset('css/jquery-ui-slider-pips.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('css/easydropdown/easydropdown.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(URL::asset('css/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('css/vendor.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('css/app.css')); ?>" rel="stylesheet">

</head>
<body class="fade-nav <?php echo e(isset($bodyclasses) ? $bodyclasses : ''); ?>" id="app-layout" ng-app="XMovement" ng-controller="ExploreController">

	<?php echo $__env->make('google-analytics', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('facebook-sdk', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php if( Session::has('flash_message') ): ?>

        <div class="flash <?php echo e(Session::get('flash_type')); ?>">
            <?php echo e(Session::get('flash_message')); ?>

			<div class="flash-dismiss" onClick="$(this).parent().fadeOut()">
				<i class="fa fa-times"></i>
			</div>
        </div>

    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('modals/auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-route.min.js"></script>

	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script src='<?php echo e(URL::asset('js/file_uploader/vendor/jquery.ui.widget.js')); ?>'></script>
    <script src='<?php echo e(URL::asset('js/file_uploader/jquery.iframe-transport.js')); ?>'></script>
    <script src='<?php echo e(URL::asset('js/file_uploader/jquery.fileupload.js')); ?>'></script>

	<script src="<?php echo e(URL::asset('js/app.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/vendor.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/easydropdown/jquery.easydropdown.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('css/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>

	<script src="<?php echo e(URL::asset('scripts/app.js')); ?>"></script>

</body>
</html>

<div class="modal fade auth-modal" id="auth-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="<?php echo e(((Session::pull('auth_type') or 'register') == 'register') ? 'active' : ''); ?>" id="register-tab"><a href="#register-panel" aria-controls="register-panel" role="tab" data-toggle="tab"><?php echo e('Register'); ?></a></li>
					<li role="presentation" class="<?php echo e(((Session::pull('auth_type') or '') == 'login') ? 'active' : ''); ?>" id="login-tab"><a href="#login-panel" aria-controls="login-panel" role="tab" data-toggle="tab"><?php echo e('Login'); ?></a></li>
				</ul>

			</div>

			<div class="modal-body">

				<div role="tabpanel">
				
					<div class="tab-content">
						
						<div role="tabpanel" class="tab-pane <?php echo e(((Session::pull('auth_type') or 'register') == 'register') ? 'active' : ''); ?>" id="register-panel">

							<?php echo $__env->make('forms/register', ['type' => 'quick'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

						</div>

						<div role="tabpanel" class="tab-pane <?php echo e(((Session::pull('auth_type') or '') == 'login') ? 'active' : ''); ?>" id="login-panel">

							<?php echo $__env->make('forms/login', ['type' => 'quick'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

						</div>

					</div>

				</div>
				
			</div>

		</div>

	</div>

</div>
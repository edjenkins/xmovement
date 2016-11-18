<div class="modal fade auth-modal" id="auth-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="{{ ((Session::pull('auth_type') or 'register') == 'register') ? 'active' : '' }}" id="register-tab"><a href="#register-panel" aria-controls="register-panel" role="tab" data-toggle="tab">{{ trans('auth.register') }}</a></li>
					<li role="presentation" class="{{ ((Session::pull('auth_type') or '') == 'login') ? 'active' : '' }}" id="login-tab"><a href="#login-panel" aria-controls="login-panel" role="tab" data-toggle="tab">{{ trans('auth.login') }}</a></li>
				</ul>

			</div>

			<div class="modal-body">

				<div role="tabpanel">

					<div class="tab-content">

						<div role="tabpanel" class="tab-pane {{ ((Session::pull('auth_type') or 'register') == 'register') ? 'active' : '' }}" id="register-panel">

							@include('forms/register', ['type' => 'quick'])

						</div>

						<div role="tabpanel" class="tab-pane {{ ((Session::pull('auth_type') or '') == 'login') ? 'active' : '' }}" id="login-panel">

							@include('forms/login', ['type' => 'quick'])

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

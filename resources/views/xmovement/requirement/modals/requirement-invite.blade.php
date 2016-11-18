<div class="modal fade" id="requirement-invite-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title">{{ trans('xmovement_requirement.modal.suggest') }}</h4>

			</div>

			<div class="modal-body">

				<p class="text-muted">
					{{ trans('xmovement_requirement.modal.tip') }}
				</p>

				<input id="invitation-name" type="text" placeholder="{{ trans('xmovement_requirement.modal.name_placeholder') }}" />

				<input id="invitation-email" type="text" placeholder="{{ trans('xmovement_requirement.modal.email_placeholder') }}" />

				<textarea id="invitation-message" row="4" placeholder="{{ trans('xmovement_requirement.modal.custom_message_placeholder') }}"></textarea>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-primary" id="send-invitation-button" data-requirement-id="{{ $requirement->id }}">{{ trans('xmovement_requirement.modal.send') }}</button>

			</div>

		</div>

	</div>

</div>

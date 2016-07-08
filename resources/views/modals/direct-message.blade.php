<div class="modal fade" id="direct-message-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<form action="{{ action('MessagesController@send') }}" method="POST">
				{!! csrf_field() !!}
				<input type="hidden" name="user_id" value="{{ $user->id }}">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title">{{ trans('messages.send_direct_message') }}</h4>

				</div>

				<div class="modal-body">

					<p class="text-muted">
						{{ trans('messages.instruction', ['name' => $user->name]) }}
					</p>

					<textarea class="expanding" name="text" rows="4" placeholder="{{ trans('messages.placeholder') }}"></textarea>

				</div>

				<div class="modal-footer">

					<button type="submit" class="btn btn-primary action-button">{{ trans('messages.send') }}</button>

				</div>

			</form>

		</div>

	</div>

</div>

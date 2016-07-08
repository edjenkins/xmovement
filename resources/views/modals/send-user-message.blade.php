<div class="modal fade" id="send-user-message-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title">{{ trans('messages.send_direct_message') }}</h4>

			</div>

			<div class="modal-body">

			</div>

			<div class="modal-footer">

		        <form action="{{ action('MessageController@sendMessage', $user) }}" method="POST">
		            {!! csrf_field() !!}

					<button type="submit" class="btn btn-primary action-button">{{ trans('messages.send') }}</button>
		        </form>

			</div>

		</div>

	</div>

</div>

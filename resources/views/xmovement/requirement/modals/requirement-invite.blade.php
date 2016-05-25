<div class="modal fade" id="requirement-invite-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title">Suggest someone you know</h4>

			</div>

			<div class="modal-body">

				<p class="text-muted">
					Invite someone to fill this requirement. If they do not have an account they will have to register and support this idea first.
				</p>

				<input id="invitation-name" type="text" placeholder="Name" />

				<input id="invitation-email" type="text" placeholder="Email address" />

				<textarea id="invitation-message" row="4" placeholder="Write a custom message here..."></textarea>
				
			</div>
		
			<div class="modal-footer">
					
				<button type="button" class="btn btn-primary" id="send-invitation-button" data-requirement-id="{{ $requirement->id }}">Send Invitation</button>

			</div>

		</div>

	</div>

</div>
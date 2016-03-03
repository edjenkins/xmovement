<div class="modal fade auth-modal" id="support-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				@can('support', $idea)

					<h4 class="modal-title" id="support-modal">Confirm Support</h4>

				@else

					<h4 class="modal-title" id="support-modal">Create an Account</h4>

				@endcan

			</div>

			<div class="modal-body">

				@can('support', $idea)

					<p class="text-muted">
						Please confirm your support by completing the CAPTCHA below.
					</p>
					
					<ul class="error-list" id="support-errors"></ul>
					
					<hr />

					<div class="g-recaptcha" data-sitekey="{{ getenv('CAPTCHA_SITE_KEY') }}"></div>

				@else

					@include('forms/register', ['type' => 'quick'])

				@endcan
				
			</div>
		
			@can('support', $idea)

				<div class="modal-footer">
						
					<button type="button" class="btn btn-primary" id="confirm-support-button" data-action-type="support" data-idea-id="{{ $idea->id }}" data-user-id="{{ Auth::user()->id }}">Confirm Support</button>

				</div>

			@endcan

		</div>

	</div>

</div>

<script src="/js/ideas/support.js"></script>
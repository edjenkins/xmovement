<div class="modal fade" id="open-design-phase-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" id="support-modal">Open Design Phase Early</h4>

			</div>

			<div class="modal-body">

				<p>
					As the idea creator you can open the design phase at any time, however please note that it is not possible to revert this action.
				</p>

				<br />

				<p class="text-muted">
					By opening the design phase early you will be inviting supporters to contribute to the design of your idea. Make sure you are happy with the number of supporters before continuing.
				</p>

			</div>

			<div class="modal-footer">

		        <form action="{{ action('IdeaController@openDesignPhase', $idea) }}" method="POST">
		            {!! csrf_field() !!}

					<button type="submit" class="btn btn-primary action-button">{{ trans('idea.open_design_phase') }}</button>
		        </form>

			</div>

		</div>

	</div>

</div>

<div class="modal fade" id="open-design-phase-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" id="support-modal">{{ trans('idea.open_design_phase_early') }}</h4>

			</div>

			<div class="modal-body">

				<p>
					{{ trans('idea.open_design_phase_early_header') }}
				</p>

				<br />

				<p class="text-muted">
					{{ trans('idea.open_design_phase_early_subheader') }}
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

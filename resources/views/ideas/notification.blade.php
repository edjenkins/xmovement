@if ($idea->design_state == 'open')

	<div class="notification design-phase-notification">
		<p>
			{{ trans('idea.design_phase_open_notification') }}
		</p>
	</div>

@elseif ($idea->proposal_state == 'open')

	<div class="notification proposal-phase-notification">
		<p>
			{{ trans('idea.proposal_phase_open_notification') }}
		</p>
	</div>

@endif

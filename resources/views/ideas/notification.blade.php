@if ($idea->tender_state == 'open')

	<div class="notification tender-phase-notification">
		<p>
			{{ trans('idea.tender_phase_open_notification') }}
		</p>
	</div>

@elseif ($idea->proposal_state == 'open')

	<div class="notification proposal-phase-notification">
		<p>
			{{ trans('idea.proposal_phase_open_notification') }}
		</p>
	</div>

@elseif ($idea->design_state == 'open')

		<div class="notification design-phase-notification">
			<p>
				{{ trans('idea.design_phase_open_notification') }}
			</p>
		</div>

@endif

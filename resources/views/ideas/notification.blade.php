@if ($idea->tender_state == 'open')

	<div class="notification">
		<p>
			{{ trans('idea.tender_phase_open_notification') }}
		</p>
	</div>

@elseif ($idea->proposal_state == 'open')

	<div class="notification">
		<p>
			{{ trans('idea.proposal_phase_open_notification') }}
		</p>
	</div>

@elseif ($idea->design_state == 'open')

		<div class="notification">
			<p>
				{{ trans('idea.design_phase_open_notification') }}
			</p>
		</div>

@elseif ($idea->support_state() == 'failed')

		<div class="notification">
			<p>
				{{ trans('idea.support_phase_failed') }}
			</p>
		</div>

@endif

<div class="idea-progress-bar">

	<div class="ipb-line ipb-placeholder-line"></div>
	
	<div class="ipb-line ipb-progress-line" style="right: {{ (100 - $idea->progress_percentage()) }}%"></div>

	<div class="ipb-dot ipb-end-dot {{ ($idea->progress_percentage() >= 100) ? 'complete' : '' }}">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_complete') }}
			</div>
		</div>
	</div>

	<a target="_self" href="{{ action('IdeaController@view', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(3px + {{ $idea->support_percentage() }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_support') }}
			</div>
		</div>
	</a>

	<a target="_self" href="{{ action('DesignController@dashboard', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(3px + {{ $idea->design_percentage() }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_design') }}
			</div>
		</div>
	</a>

	<a target="_self" href="{{ action('ProposeController@index', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(3px + {{ $idea->proposal_percentage() }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_propose') }}
			</div>
		</div>
	</a>

	<a target="_self" href="{{ action('TenderController@index', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(3px + {{ $idea->tender_percentage() }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_tender') }}
			</div>
		</div>
	</a>

</div>

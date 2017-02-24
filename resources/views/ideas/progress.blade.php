<div class="idea-progress-bar">

	<!-- Inspiration -->
	@if (DynamicConfig::fetchConfig('INSPIRATION_PHASE_ENABLED', false))
		<a target="_self" href="{{ action('IdeaController@view', $idea) }}" class="ipb-dot ipb-milestone-dot" style="right: calc(100% - {{ ($idea->support_percentage()) }}%)">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_inspiration') }}
				</div>
			</div>
		</a>
		<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: {{ $idea->inspiration_percentage() }}%; right: calc(100% - {{ ($idea->progress_percentage() > $idea->support_percentage()) ? $idea->support_percentage() : $idea->progress_percentage() }}%);"></div>
	@endif

	<!-- Support -->
	<a target="_self" href="{{ action('IdeaController@view', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(5px + {{ $idea->support_percentage() }}%); right: calc(100% - {{ ($idea->design_percentage()) }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_support') }}
			</div>
		</div>
	</a>
	<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: calc(5px + {{ $idea->support_percentage() }}%); right: calc(100% - {{ ($idea->progress_percentage() > $idea->design_percentage()) ? $idea->design_percentage() : $idea->progress_percentage() }}%);"></div>

	<!-- Design -->
	<a target="_self" href="{{ action('DesignController@dashboard', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(5px + {{ $idea->design_percentage() }}%); right: calc(100% - {{ ($idea->proposal_percentage()) }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_design') }}
			</div>
		</div>
	</a>
	<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: calc(5px + {{ $idea->design_percentage() }}%); right: calc(100% - {{ ($idea->progress_percentage() > $idea->proposal_percentage()) ? $idea->proposal_percentage() : $idea->progress_percentage() }}%);"></div>

	<!-- Propose -->
	<a target="_self" href="{{ action('ProposeController@index', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(5px + {{ $idea->proposal_percentage() }}%); right: calc(100% - {{ (DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false)) ? $idea->tender_percentage() : 100 }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_propose') }}
			</div>
		</div>
	</a>
	<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: calc(5px + {{ $idea->proposal_percentage() }}%); right: calc(100% - {{ (DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false)) ? (  ($idea->progress_percentage() > $idea->tender_percentage()) ? $idea->tender_percentage() : $idea->progress_percentage()  ) : 100 }}%);"></div>

	<!-- Tender -->
	@if (DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false))
		<a target="_self" href="{{ action('TenderController@index', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(5px + {{ $idea->tender_percentage() }}%); right: 0;">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_tender') }}
				</div>
			</div>
		</a>
	@endif

</div>

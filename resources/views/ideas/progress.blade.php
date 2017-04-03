@if (false)

	<pre>
		inspiration_percentage -> {{ ($idea->inspiration_percentage()) }}
		support_percentage -> {{ ($idea->support_percentage()) }}
		design_percentage -> {{ ($idea->design_percentage()) }}
		proposal_percentage -> {{ ($idea->proposal_percentage()) }}
		tender_percentage -> {{ ($idea->tender_percentage()) }}
		progress_percentage -> {{ ($idea->progress_percentage()) }}
	</pre>

@endif

<div class="idea-progress-bar">

	<!-- Support -->
	<a target="_self" href="{{ action('IdeaController@view', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: 5px; right: calc(100% - {{ ($idea->design_percentage()) }}%)">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_support') }}
			</div>
		</div>
	</a>
	<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: 5px; right: calc(100% - {{ ($idea->progress_percentage() > $idea->design_percentage()) ? $idea->design_percentage() : $idea->progress_percentage() }}%);"></div>

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

	<?php
	$propose_overlay_right = 0;

	if (DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false))
	{
		// Tender phase enabled so calculate with that in mind
		if ($idea->progress_percentage() > $idea->tender_percentage())
		{
			// Total progress has passed start of tender phase
			$propose_overlay_right = 100 - $idea->tender_percentage();
		}
		else
		{
			$propose_overlay_right = 100 - $idea->progress_percentage();
		}
	}
	else
	{
		// Tender phase not enabled so calculate with that in mind
		$propose_overlay_right = 100 - $idea->progress_percentage();
	}
	?>

	<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: calc(5px + {{ $idea->proposal_percentage() }}%); right: {{ $propose_overlay_right }}%;"></div>

	<!-- Tender -->
	@if (DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false))
		<a target="_self" href="{{ action('TenderController@index', $idea) }}" class="ipb-dot ipb-milestone-dot" style="left: calc(5px + {{ $idea->tender_percentage() }}%); right: 0;">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_tender') }}
				</div>
			</div>
		</a>
		<div class="ipb-dot ipb-milestone-dot ipb-progress-overlay" style="left: calc(5px + {{ $idea->tender_percentage() }}%); right: calc(100% - {{ $idea->progress_percentage() }}%);"></div>
	@endif

</div>

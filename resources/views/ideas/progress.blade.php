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
	<a class="ipb-phase ipb-locked" target="_self" href="{{ action('IdeaController@view', $idea) }}">
		<div class="ipb-label">
			<span class="ipb-label-text">
				@if ($idea->support_state == 'locked')
					<i class="fa fa-fw fa-lock"></i>
				@endif
				{{ trans('idea.progress_support') }}
			</span>
		</div>
	</a>

	<!-- Design -->
	<a class="ipb-phase ipb-open" target="_self" href="{{ action('DesignController@dashboard', $idea) }}">
		<i class="fa fa-arrow-right left-arrow"></i>
		<i class="fa fa-arrow-right right-arrow"></i>
		<div class="ipb-label">
			<span class="ipb-label-text">
				@if ($idea->design_state == 'locked')
					<i class="fa fa-fw fa-lock"></i>
				@endif
				{{ trans('idea.progress_design') }}
			</span>
		</div>
	</a>

	<!-- Plan -->
	<a class="ipb-phase" target="_self" href="{{ action('ProposeController@index', $idea) }}">
		<div class="ipb-label">
			<span class="ipb-label-text">
				@if ($idea->proposal_state == 'locked')
					<i class="fa fa-fw fa-lock"></i>
				@endif
				{{ trans('idea.progress_propose') }}
			</span>
		</div>
	</a>

	<div class="clearfloat"></div>

</div>

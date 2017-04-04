<div class="idea-progress-bar clearfix">

	<!-- Support -->
	<a class="ipb-phase {{ ($idea->support_state() == 'open') ? 'ipb-open' : '' }} {{ ($idea->support_state() == 'locked') ? 'ipb-locked' : '' }}" target="_self" href="{{ action('IdeaController@view', $idea) }}">
		<div class="ipb-label">
			<span class="ipb-label-text">
				<i class="fa fa-fw fa-lock"></i>
				{{ trans('idea.progress_support') }}
			</span>
		</div>
	</a>

	<!-- Design -->
	<a class="ipb-phase {{ ($idea->design_state() == 'open') ? 'ipb-open' : '' }} {{ ($idea->design_state() == 'locked') ? 'ipb-locked' : '' }}" target="_self" href="{{ action('DesignController@dashboard', $idea) }}">
		<i class="fa fa-long-arrow-right left-arrow"></i>
		<i class="fa fa-long-arrow-right right-arrow"></i>
		<div class="ipb-label">
			<span class="ipb-label-text">
				<i class="fa fa-fw fa-lock"></i>
				{{ trans('idea.progress_design') }}
			</span>
		</div>
	</a>

	<!-- Plan -->
	<a class="ipb-phase {{ ($idea->plan_state() == 'open') ? 'ipb-open' : '' }} {{ ($idea->plan_state() == 'locked') ? 'ipb-locked' : '' }}" target="_self" href="{{ action('ProposeController@index', $idea) }}">
		<div class="ipb-label">
			<span class="ipb-label-text">
				<i class="fa fa-fw fa-lock"></i>
				{{ trans('idea.progress_propose') }}
			</span>
		</div>
	</a>

</div>

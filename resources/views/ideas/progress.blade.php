<div class="idea-progress-bar {{ (($idea->design_state == 'open') || ($idea->proposal_state == 'open')) ? 'has-notification' : '' }}">

	<div class="ipb-line ipb-placeholder-line"></div>
	<div class="ipb-line ipb-progress-line" style="right: {{ (100 - $idea->progress_percentage()) }}%"></div>

	<div class="ipb-progress-arrow" style="right: {{ (100 - $idea->progress_percentage()) }}%"></div>

	<a href="{{ action('IdeaController@view', $idea) }}" class="ipb-dot ipb-start-dot complete">
		<div class="ipb-label">
			<div class="ipb-label-text">
				@if(($idea->design_percentage() + $idea->proposal_percentage()) == 0)
					{{ trans('idea.progress_support_design_propose') }}
				@elseif($idea->design_percentage() == 0)
					{{ trans('idea.progress_support_design') }}
				@else
					{{ trans('idea.progress_support') }}
				@endif
			</div>
		</div>
	</a>
	<div class="ipb-dot ipb-end-dot {{ ($idea->progress_percentage() >= 100) ? 'complete' : '' }}">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.progress_complete') }}
			</div>
		</div>
	</div>

	@if(($idea->design_percentage() + $idea->proposal_percentage()) == 0)
		<a href="{{ action('DesignController@dashboard', $idea) }}" class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_support_design_propose') }}
				</div>
			</div>
		</a>
	@elseif($idea->design_percentage() == $idea->proposal_percentage())
		<a href="{{ action('DesignController@dashboard', $idea) }}" class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_design_propose') }}
				</div>
			</div>
		</a>
	@else
		@unless($idea->design_percentage() == 0)
			<a href="{{ action('DesignController@dashboard', $idea) }}" class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%" onClick="document.location='{{ action('DesignController@dashboard', $idea) }}'">
				<div class="ipb-label">
					<div class="ipb-label-text">
						{{ trans('idea.progress_design') }}
					</div>
				</div>
			</a>
		@endunless
		<a href="{{ action('ProposeController@index', $idea) }}" class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->proposal_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->proposal_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_propose') }}
				</div>
			</div>
		</a>
	@endif

</div>

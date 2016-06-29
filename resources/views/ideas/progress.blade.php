<div class="idea-progress-bar">

	<div class="ipb-line ipb-placeholder-line"></div>
	<div class="ipb-line ipb-progress-line" style="width: {{ $idea->progress_percentage() }}%"></div>

	<div class="ipb-dot ipb-start-dot complete">
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
	</div>
	<div class="ipb-dot ipb-end-dot {{ ($idea->progress_percentage() >= 100) ? 'complete' : '' }}">
		<div class="ipb-label">
			<div class="ipb-label-text">
				{{ trans('idea.complete') }}
			</div>
		</div>
	</div>

	@if(($idea->design_percentage() + $idea->proposal_percentage()) == 0)
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_support_design_propose') }}
				</div>
			</div>
		</div>
	@elseif($idea->design_percentage() == $idea->proposal_percentage())
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_design_propose') }}
				</div>
			</div>
		</div>
	@else
		@unless($idea->design_percentage() == 0)
			<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
				<div class="ipb-label">
					<div class="ipb-label-text">
						{{ trans('idea.progress_design') }}
					</div>
				</div>
			</div>
		@endunless
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->proposal_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->proposal_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					{{ trans('idea.progress_propose') }}
				</div>
			</div>
		</div>
	@endif

</div>

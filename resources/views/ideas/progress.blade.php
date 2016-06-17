<div class="idea-progress-bar">

	<div class="ipb-line ipb-placeholder-line"></div>
	<div class="ipb-line ipb-progress-line" style="width: {{ $idea->progress_percentage() }}%"></div>

	<div class="ipb-dot ipb-start-dot">
		<div class="ipb-label">
			<div class="ipb-label-text">
				@if(($idea->design_percentage() + $idea->proposal_percentage()) == 0)
					Support/Design/Propose
				@elseif($idea->design_percentage() == 0)
					Support/Design
				@else
					Support
				@endif
			</div>
		</div>
	</div>
	<div class="ipb-dot ipb-end-dot">
		<div class="ipb-label">
			<div class="ipb-label-text">
				Complete
			</div>
		</div>
	</div>

	@if(($idea->design_percentage() + $idea->proposal_percentage()) == 0)
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					Support/Design/Propose
				</div>
			</div>
		</div>
	@elseif($idea->design_percentage() == $idea->proposal_percentage())
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					Design/Propose
				</div>
			</div>
		</div>
	@else
		@unless($idea->design_percentage() == 0)
			<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->design_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->design_percentage() }}%">
				<div class="ipb-label">
					<div class="ipb-label-text">
						Design
					</div>
				</div>
			</div>
		@endunless
		<div class="ipb-dot ipb-milestone-dot {{ ($idea->progress_percentage() > $idea->proposal_percentage()) ? 'complete' : '' }}" style="left: {{ $idea->proposal_percentage() }}%">
			<div class="ipb-label">
				<div class="ipb-label-text">
					Propose
				</div>
			</div>
		</div>
	@endif

</div>

<div class="tile-footer">

	@can('voteOnDesignTasks', $design_task)

		@if($design_task['pinned'])

			<p>
				<i class="fa fa-thumb-tack"></i>
				Pinned
			</p>

		@else

			<div class="design-task-vote-container {{ ($design_task->voteCount() == 0) ? '' : (($design_task->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
				<div class="vote-controls">
					<div class="vote-button vote-up {{ ($design_task->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="design_task" data-votable-id="{{ $design_task['id'] }}">
						<i class="fa fa-2x fa-angle-up"></i>
					</div>
					<div class="vote-count">
						{{ $design_task->voteCount() }}
					</div>
					<div class="vote-button vote-down {{ ($design_task->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="design_task" data-votable-id="{{ $design_task['id'] }}">
						<i class="fa fa-2x fa-angle-down"></i>
					</div>
				</div>
			</div>

		@endif

	@else

		<p onClick="alert('Support this idea to contribute to the design.')">
			<i class="fa fa-lock"></i>
			Locked
		</p>

	@endcan

</div>
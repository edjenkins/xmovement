<div class="tile-footer">

	@can('vote_on_design_tasks', $design_task)

		@if($design_task['pinned'])

			<p>
				<i class="fa fa-thumb-tack"></i>
				Pinned
			</p>

		@else

			<div class="design-task-vote-container {{ ($design_task->voteCount() == 0) ? '' : (($design_task->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
				<div class="vote-controls">
					<div class="vote-button vote-up {{ ($design_task->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="design_task" data-votable-id="{{ $design_task['id'] }}">
						<i class="fa fa-lg fa-thumbs-up"></i>
					</div>
					<div class="vote-count">
						{{ $design_task->voteCount() }}
					</div>
					<div class="vote-button vote-down {{ ($design_task->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="design_task" data-votable-id="{{ $design_task['id'] }}">
						<i class="fa fa-lg fa-thumbs-down"></i>
					</div>
				</div>
			</div>

		@endif

	@else

		<p>
			<i class="fa fa-lock"></i>
			Locked
		</p>

	@endcan

</div>

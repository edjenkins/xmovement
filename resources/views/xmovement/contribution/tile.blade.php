<div class="xmovement-tile">

    <a href="/design/contribution/{{ $design_task['id'] }}">
    	<div class="tile-body">
	    
		    <span class="vertically-aligned-text">

		    	<h4>{{ $design_task['name'] }}</h4>
		    	
		    	<p>
					<i class="fa fa-lightbulb-o"></i>
		    		{{ $contribution->contributionSubmissions->count() }}
		    	</p>

		    </span>

		</div>

	</a>

	<div class="tile-footer">

		@if($design_task['locked'] == true)
		
			<p>
				<i class="fa fa-lock"></i>
				Locked
			</p>
		
		@else
			
			<div class="vote-container design-task-vote-container {{ ($design_task->voteCount() == 0) ? '' : (($design_task->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
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
		
	</div>

</div>
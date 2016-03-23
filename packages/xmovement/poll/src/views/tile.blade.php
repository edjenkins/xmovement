<div class="xmovement-tile">

    <a href="/design/poll/{{ $module['id'] }}">
    	<div class="tile-body">
	    
		    <span class="vertically-aligned-text">

		    	<h4>{{ $module['name'] }}</h4>
		    	
		    	<p>
					<i class="fa fa-lightbulb-o"></i>
		    		{{ $poll->pollOptions->count() }}
		    	</p>

		    </span>

		</div>

	</a>

	<div class="tile-footer">

		@if($module['locked'] == true)
		
			<p>
				<i class="fa fa-lock"></i>
				Locked
			</p>
		
		@else
			
			<div class="vote-container design-module-vote-container">
				<div class="vote-controls">
					<div class="vote-button vote-up" data-vote-direction="up" data-votable-type="design_module" data-votable-id="{{ $module['id'] }}">
						<i class="fa fa-2x fa-angle-up"></i>
					</div>
					<div class="vote-count {{ ($module->voteCount() >= 0) ? 'positive-vote' : 'negative-vote' }}">
						{{ $module->voteCount() }}
					</div>
					<div class="vote-button vote-down" data-vote-direction="down" data-votable-type="design_module" data-votable-id="{{ $module['id'] }}">
						<i class="fa fa-2x fa-angle-down"></i>
					</div>
				</div>
			</div>

		@endif
		
	</div>

</div>
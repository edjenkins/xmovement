<div class="xmovement-tile">

    <a href="/design/poll/{{ $poll['id'] }}">
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
			
			<ul class="voting-controls">
				<li class="vote-button vote-up" data-vote-direction="up" data-design-module-id="{{ $module['id'] }}">
					<i class="fa fa-2x fa-angle-up"></i>
				</li>
				<li class="vote-count">
					<p>{{ $module->voteCount() }}</p>
				</li>
				<li class="vote-button vote-down" data-vote-direction="down" data-design-module-id="{{ $module['id'] }}">
					<i class="fa fa-2x fa-angle-down"></i>
				</li>
			</ul>

		@endif
		
	</div>

</div>
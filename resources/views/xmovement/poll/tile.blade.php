<div class="xmovement-tile">

    <div class="tile-body" onClick="document.location = '/design/poll/{{ $poll['id'] }}'">
	    
	    <span class="vertically-aligned-text">

	    	<h4>{{ $poll['name'] }}</h4>
	    	<p>
	    		<i class="fa fa-user"></i>
	    		32
	    	</p>

	    </span>

	</div>

	<div class="tile-footer">

		@if($poll['locked'] == true)
		
			<p>
				<i class="fa fa-lock"></i>
				Locked
			</p>
		
		@else
			
			<ul class="voting-controls">
				<li class="vote-up">
					<i class="fa fa-2x fa-angle-up"></i>
				</li>
				<li class="vote-count">
					<p>23</p>
				</li>
				<li class="vote-down">
					<i class="fa fa-2x fa-angle-down"></i>
				</li>
			</ul>

		@endif
		
	</div>

</div>
<div class="tile proposal-tile">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('https://s3.amazonaws.com/xmovement/uploads/images/small/{{ $proposal->user->avatar }}?name={{ urlencode($proposal->user->name) }}')"></div>
	</div>

	<div class="tile-body">

		<h5 class="proposal-description">
			{{ str_limit($proposal->description, $limit = 80, $end = '...') }}
		</h5>

		<p>
			@if($idea->proposal_state == 'locked' && $index == 0)
				<div class="winner-banner">WINNER</div>
			@else
				Added {{ $proposal->created_at->diffForHumans() }}
			@endif
		</p>
		<p>
			Posted by <a href="{{ action('UserController@profile', [$proposal->user]) }}">{{ $proposal->user->name or $proposal->user_id }}</a>
		</p>

	</div>

	<div class="tile-footer">

		<a href="{{ action('ProposeController@view', $proposal->id) }}">
			View Proposal
		</a>

	</div>

</div>

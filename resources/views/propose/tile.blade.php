<div class="tile proposal-tile">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('/uploads/images/small/{{ $proposal->user->avatar }}/{{ urlencode($proposal->user->name) }}')"></div>
	</div>

	<div class="tile-body">

		<h5 class="proposal-description">
			{{ str_limit($proposal->description, $limit = 80, $end = '...') }}
		</h5>

		<p>
			Added {{ $proposal->created_at->diffForHumans() }}
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

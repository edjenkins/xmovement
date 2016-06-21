<div class="tile proposal-tile">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('https://s3.amazonaws.com/xmovement/uploads/images/small/{{ $proposal->user->avatar }}')"></div>
	</div>

	<div class="tile-body">

		<h5 class="proposal-description">
			{{ $proposal->description }}
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
			Read Proposal
		</a>

	</div>

</div>

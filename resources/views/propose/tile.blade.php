<div class="tile proposal-tile" onClick="document.location = '{{ action('ProposeController@view', $proposal->id) }}'">
	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('/uploads/images/small/{{ $proposal->user->avatar }}')"></div>
	</div>

	<div class="inner-container">
		<p>
			Description - {{ $proposal->description }}
		</p>
		<p>
			Posted by <a href="{{ action('UserController@profile', [$proposal->user]) }}">{{ $proposal->user->name or $proposal->user_id }}</a>
		</p>
	</div>
</div>

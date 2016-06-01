<div class="tile proposal-tile" onClick="document.location = '{{ action('ProposeController@view', $proposal->id) }}'">
	<div class="inner-container">
		<p>
			{{ $proposal->body }}
		</p>
	</div>
	<div class="tile-footer">
		<p>
		    Posted by <a href="{{ action('UserController@profile', [$proposal->user]) }}">{{ $proposal->user->name or $proposal->user_id }}</a>
		</p>
	</div>
</div>

<div class="tile idea-tile">
	<a href="{{ action('IdeaController@view', $idea->id) }}" class="tile-image" style="background-image:url('uploads/images/large/{{ $idea->photo }}')"></a>
	<div class="inner-container">
		<a class="idea-name" href="{{ action('IdeaController@view', $idea->id) }}">
		    {{ str_limit($idea->name, $limit = 50, $end = '...') }}
		</a>
		<p class="idea-description">
			{{ str_limit($idea->description, $limit = 100, $end = '...') }}
		</p>
	</div>
	<div class="tile-footer">
		<p>
		    Posted by <a href="{{ action('UserController@profile', [$idea->user]) }}">{{ $idea->user->name or $idea->user_id }}</a>
		</p>
	</div>
</div>

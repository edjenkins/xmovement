<div class="tile idea-tile">
	<a href="{{ action('IdeaController@view', $idea->id) }}" class="tile-image" style="background-image:url('https://s3.amazonaws.com/xmovement/uploads/images/large/{{ $idea->photo }}')"></a>
	<div class="inner-container">
		<a class="idea-name" href="{{ action('IdeaController@view', $idea->id) }}">
		    {{ str_limit($idea->name, $limit = 50, $end = '...') }}
		</a>
		<p class="idea-description">
			{{ str_limit($idea->description, $limit = 150, $end = '...') }}
		</p>
	</div>
	<div class="tile-footer">
		@include('ideas/progress')
	</div>
</div>

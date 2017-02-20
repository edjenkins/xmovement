<div class="idea-tile mini-tile" onClick="document.location = '{{ action('IdeaController@view', $idea->id) }}'">
	<div class="inner-container">
		<a target="_self" href="{{ action('IdeaController@view', $idea->id) }}" class="tile-image" style="background-image:url('{{ ResourceImage::getImage($idea->photo, 'large') }}')"></a>
		<h4>
			{{ $idea->name }}
		</h4>
	</div>
</div>

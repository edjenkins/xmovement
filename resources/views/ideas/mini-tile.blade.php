<div class="tile idea-tile mini-tile" onClick="document.location = '{{ action('IdeaController@view', $idea->id) }}'">
	<div class="inner-container">
		<h4>
		    {{ $idea->name }}
		</h4>
	</div>
</div>
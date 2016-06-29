<div class="idea-tile mini-tile" onClick="document.location = '{{ action('IdeaController@view', $idea->id) }}'">
	<div class="inner-container">
		<h4>
			<i class="fa fa-circle-o"></i>
			{{ $idea->name }}
		</h4>
	</div>
</div>

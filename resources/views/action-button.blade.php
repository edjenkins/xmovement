<div class="action-button">

	@can('support', $idea)

		<div class="btn btn-primary">Support this Idea</div>

	@endcan
	
	@can('design', $idea)

		<div class="btn btn-primary">Help Design</div>

	@endcan

	@can('edit', $idea)
		
		<a href="{{ action('IdeaController@edit', $idea) }}" class="btn btn-warning">Edit Idea</a>

	@endcan

	@can('destroy', $idea)
        
        <form action="{{ action('IdeaController@destroy', $idea) }}" method="POST">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}

			<button type="submit" class="btn btn-danger">Delete Idea</button>
        </form>
		
	@endcan

</div>
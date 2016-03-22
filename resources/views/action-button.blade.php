<div class="action-buttons">

	@if (Auth::check())

		@can('support', $idea)
		
			<div class="btn btn-primary" id="support-button" data-toggle="modal" data-target="#support-modal">Support this Idea</div>

		@endcan

	@else

		<div class="btn btn-primary" id="support-button" data-toggle="modal" data-target="#auth-modal">Support this Idea</div>

	@endif

	@can('design', $idea)

		<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">Help Design</a>

	@endcan

	@can('edit', $idea)
		
		<a href="{{ action('IdeaController@edit', $idea) }}" class="btn btn-warning action-button">Edit Idea</a>

	@endcan

	@can('destroy', $idea)
        
        <form action="{{ action('IdeaController@destroy', $idea) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}

			<button type="submit" class="btn btn-danger action-button">Delete Idea</button>
        </form>
		
	@endcan

</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="action-buttons">

	@can('support', $idea)

		<div class="btn btn-primary" id="support-button" data-toggle="modal" data-target="#support-modal">Support this Idea</div>

	@endcan
	
	@can('design', $idea)

		<div class="btn btn-primary action-button">Help Design</div>

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

<script src="/js/ideas/action-button.js"></script>
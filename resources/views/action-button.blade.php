<div class="action-buttons">

	@if (Auth::check())

		@can('support', $idea)

			<div class="btn btn-primary" id="support-button" data-toggle="modal" data-target="#support-modal" data-design-link="{{ action('DesignController@dashboard', $idea) }}">Support this Idea</div>

		@endcan

	@else

		<div class="btn btn-primary" id="support-button" data-toggle="modal" data-target="#auth-modal">Support this Idea</div>

	@endif

	@can('propose', $idea)

		<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">View Proposals</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">View Proposals</a>

		@endif

	@endcan

	@can('design', $idea)

		<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">Help Design</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">View Design</a>

		@endif

	@endcan

	@can('design_after_support', $idea)

		<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button" id="temp-design-button">Help Design</a>

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

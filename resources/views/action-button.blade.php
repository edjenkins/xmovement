<div class="action-buttons">

	@if (Auth::check())

		@can('support', $idea)

			<div class="btn btn-primary support-button" data-toggle="modal" data-target="#support-modal" data-design-link="{{ action('DesignController@dashboard', $idea) }}">Support this Idea</div>

		@endcan

	@else

		<div class="btn btn-primary support-button" data-toggle="modal" data-target="#auth-modal">Support this Idea</div>

	@endif

	@can('design', $idea)

		<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">Design Dashboard</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">Design Dashboard</a>

		@endif

		@can('design_after_support', $idea)

			<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button temp-design-button">Design Dashboard</a>

		@endcan

	@endcan

	@can('propose', $idea)

		<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">Browse Proposals</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">Browse Proposals</a>

		@endif

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

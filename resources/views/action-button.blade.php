<div class="action-buttons">

	@if (Auth::check())

		@can('support', $idea)

			<div class="btn btn-primary support-button" data-toggle="modal" data-target="#support-modal" data-design-link="{{ action('DesignController@dashboard', $idea) }}">{{ trans('idea.support_this_idea') }}</div>

		@endcan

	@else

		<div class="btn btn-primary support-button" data-toggle="modal" data-target="#auth-modal">{{ trans('idea.support_this_idea') }}</div>

	@endif

	@can('design', $idea)

		<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">{{ trans('idea.design_dashboard') }}</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button">{{ trans('idea.design_dashboard') }}</a>

		@endif

		@can('design_after_support', $idea)

			<a href="{{ action('DesignController@dashboard', $idea) }}" class="btn btn-primary action-button temp-design-button">{{ trans('idea.design_dashboard') }}</a>

		@endcan

	@endcan

	@can('propose', $idea)

		<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">{{ trans('idea.browse_proposals') }}</a>

	@else

		@if ($idea->design_state == 'locked')

			<a href="{{ action('ProposeController@index', $idea) }}" class="btn btn-primary action-button">{{ trans('idea.browse_proposals') }}</a>

		@endif

	@endcan

	@can('edit', $idea)

		<a href="{{ action('IdeaController@edit', $idea) }}" class="btn btn-warning action-button">{{ trans('idea.edit_idea') }}</a>

	@endcan

	@can('destroy', $idea)

        <form action="{{ action('IdeaController@destroy', $idea) }}" method="POST" onsubmit="return confirm('{{ trans('idea.delete_confirmation') }}');">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}

			<button type="submit" class="btn btn-danger action-button">{{ trans('idea.delete_idea') }}</button>
        </form>

	@endcan

</div>

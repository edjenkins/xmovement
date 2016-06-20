<form class="idea-form{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? action('IdeaController@update') : action('IdeaController@store') }}" data-current-step="1">
	{!! csrf_field() !!}

	@if ($editing)
		<input type="hidden" name="id" value="{{ $idea->id }}">
	@endif

	@include('forms/idea/pages/1')

	@include('forms/idea/pages/2')

	@include('forms/idea/pages/3')

	@unless($editing)

		@include('forms/idea/pages/4')

	@endunless

</form>

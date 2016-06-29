@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ trans('idea.invite_some_friends') }}</h2>

	</div>

	<div class="container">

	    <div class="dialog">

			<h3>{{ trans('idea.congratulations') }}</h3>
			<p>{{ trans('idea.invite_description') }}</p>

			<div id="panel-container">

				<div class="col-sm-4">
					<div class="user-panel" data-index="1">
						<input type="text" class="name-field" placeholder="{{ trans('idea.name_placeholder') }}">
						<input type="text" class="email-field" placeholder="{{ trans('idea.email_placeholder') }}">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="user-panel" data-index="2">
						<input type="text" class="name-field" placeholder="{{ trans('idea.name_placeholder') }}">
						<input type="text" class="email-field" placeholder="{{ trans('idea.email_placeholder') }}">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="user-panel" data-index="3">
						<input type="text" class="name-field" placeholder="{{ trans('idea.name_placeholder') }}">
						<input type="text" class="email-field" placeholder="{{ trans('idea.email_placeholder') }}">
					</div>
				</div>

			</div>

		</div>

        <div class="button-container">

	        <form action="{{ action('IdeaController@sendInvites', $idea) }}" method="POST">
	            {!! csrf_field() !!}

		    	<input name="id" type="hidden" value="{{ $idea->id }}">

		    	<input name="data" type="hidden" id="form-data">

	        	<button type="submit" class="btn btn-primary action-button" id="continue-button">{{ trans('idea.invite_friends') }}</button>

	        </form>

            <a class="muted-link" href="{{ action('IdeaController@view', $idea) }}">{{ trans('idea.skip') }}</a>

		</div>

	</div>

@endsection

<script type="text/javascript">
	var name_placeholder = "{{ trans('idea.name_placeholder') }}";
	var email_placeholder = "{{ trans('idea.email_placeholder') }}";
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="{!! asset('js/ideas/invite.js') !!}"></script

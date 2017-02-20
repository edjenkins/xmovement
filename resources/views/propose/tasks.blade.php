@extends('layouts.app')

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">{{ trans('proposals.select_design_tasks') }}</h2>
		<h5 class="sub-title">{{ trans('proposals.select_design_tasks_subtitle') }}</h5>

	</div>

	<div class="proposal-toolbar colorful">

		<a target="_self" href="{{ action('IdeaController@view', $idea) }}">
			<button class="next-button pull-left">
				{{ trans('proposals.cancel') }}
			</button>
		</a>

		<form action="{{ action('ProposeController@tasks', $idea) }}" method="POST">
			{!! csrf_field() !!}
			<input type="hidden" name="current_task" id="current_task" value="-1">
			<input type="hidden" name="selected_tasks" id="selected_tasks" value="">
			<button class="next-button pull-right" type="submit">
				{{ trans('proposals.next') }}
			</button>
		</form>

		<div class="clearfloat"></div>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-12">

	    		<div class="column main-column">

					@foreach ($design_tasks as $design_task)

						@include('propose/task-tile', ['design_task' => $design_task])

					@endforeach

	    			<div class="clearfloat"></div>
	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/tasks.js"></script>

@endsection

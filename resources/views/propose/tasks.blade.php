@extends('layouts.app')

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">Select Design Tasks</h2>
		<h5 class="sub-title">Select the tasks you would like to include in your proposal</h5>

	</div>

	<div class="proposal-toolbar colorful">

		<a href="{{ action('IdeaController@view', $idea) }}">
			<button class="next-button pull-left">
				<i class="fa fa-home fa-2x"></i>
			</button>
		</a>

		<form action="{{ action('ProposeController@select', $idea) }}" method="POST">
			{!! csrf_field() !!}
			<input type="hidden" name="selected_tasks" id="selected_tasks" value="">
			<button class="next-button pull-right" type="submit">
				<i class="fa fa-arrow-right fa-2x"></i>
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

@extends('layouts.app')

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">Review Proposal</h2>

	</div>

	<div class="proposal-toolbar colorful">

		<form action="{{ action('ProposeController@previous') }}" method="POST">
			{!! csrf_field() !!}
			<button class="previous-button pull-left" type="submit">
				<i class="fa fa-arrow-left fa-2x"></i>
			</button>
		</form>

		<form action="{{ action('ProposeController@submit', $idea) }}" method="POST" onsubmit="return confirm('Are you sure you want to submit this proposal?');">
			{!! csrf_field() !!}
			<button class="next-button pull-right" type="submit">
				<i class="fa fa-check fa-2x"></i>
			</button>
		</form>

		<div class="clearfloat"></div>

	</div>

	<div class="container">

	    <div class="row">
			<div class="col-md-8 col-md-offset-2">

	    		<div class="column main-column proposal-preview-column">

					<ul class="proposal-preview">

						<li class="user-header">
							<div class="avatar-wrapper">
								<img class="avatar" style="background-image: url('/uploads/images/small/{{ $user->avatar }}')">
							</div>
						</li>

						@foreach($design_tasks as $design_task)

							<li class="name-header">{{ $design_task->name }}</li>
							<li class="description-header">{{ $design_task->description }}</li>

							<!--
							[id] => 6
						    [idea_id] => 21
						    [user_id] => 21
						    [name] => Time
						    [description] => What time of day is best?
						    [xmovement_task_id] => 6
						    [xmovement_task_type] => Poll
						    [locked] => 0
						    [created_at] => 2016-06-03 08:46:50
						    [updated_at] => 2016-06-03 08:46:50
							-->
						@endforeach

						<li class="add-content">
							<i class="fa fa-plus-circle fa-2x"></i>
						</li>
					</ul>

					<br />

					<button type="button" class="btn btn-primary">
						Submit Proposal
					</button>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/review.js"></script>

@endsection

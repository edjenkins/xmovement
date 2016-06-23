@extends('layouts.app')

@section('content')

	<div class="page-header {{ ($proposal_mode) ? ' colorful' : '' }}">

        <h2 class="main-title">{{ str_limit($design_task['name'], 50) }}</h2>
		<h5 class="sub-title">{{ ($proposal_mode) ? ' Select one or more poll options' : 'Poll' }}</h5>

	</div>

	@if ($proposal_mode)

		@include('propose/toolbar', ['design_task' => $design_task, 'proposal_task_index' => $proposal_task_index, 'proposal_tasks' => $proposal_tasks])

	@endif

	<div class="container">

	    <div class="row">

			@unless ($proposal_mode)

				<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

		    		<div class="column side-column">

		    		</div>

	    		</div>

			@endunless

	    	<div class="{{ (!$proposal_mode) ? 'col-md-9 col-md-pull-3' : 'col-md-10 col-md-offset-1' }}">

				@unless ($proposal_mode)

		    		<div class="view-controls-container">

		    			<ul class="module-controls pull-left">

	    					<li class="module-control">

	    						<a href="{{ action('DesignController@dashboard', $design_task->idea) }}">

			    					<i class="fa fa-chevron-left"></i>

			    					Back to Dashboard

			    				</a>

		    				</li>

		    			</ul>

		    			<ul class="module-controls pull-right">

		    				@can('submitOption', $poll)

		    					<li class="module-control">

		    						<button id="submit-poll-option">

				    					<i class="fa fa-plus"></i>

				    					Submit poll option

				    				</button>

			    				</li>

		    				@endcan

							@can('destroy', $design_task)

		    					<li class="module-control">

							        <form action="{{ action('DesignController@destroyTask', $design_task) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
							            {!! csrf_field() !!}
							            {!! method_field('DELETE') !!}

										<button type="submit"><i class="fa fa-trash"></i></button>
							        </form>

			    				</li>

		    				@endcan

		    			</ul>

		    			<div class="clearfloat"></div>

		    		</div>

				@endunless

	    		<div class="column main-column">

	    			<div class="module-description">
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('/uploads/images/small/{{ $design_task->user->avatar }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

	    			<ul class="poll-options-list {{ ($proposal_mode) ? 'proposal-mode' : '' }}">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				@include('xmovement.poll.poll-option', ['pollOption' => $pollOption])

		    			@endforeach

	    			</ul>

					@unless ($proposal_mode)

		    			@can('submitOption', $poll)

							<form id="poll-contribution-form" method="post">

				    			<div class="submit-poll-option-container" id="submit-poll-option">

				    				<input id="poll-contribution" type="text" placeholder="Submit a poll option.." data-poll-id="{{ $poll->id }}" />

				    				<button id="submit-button">Submit</button>

				    			</div>

							</form>

		    			@endcan

					@endunless

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/poll/view.js"></script>

@endsection

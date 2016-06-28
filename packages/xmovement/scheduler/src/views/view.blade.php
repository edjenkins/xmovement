@extends('layouts.app')

@section('content')

	<div class="page-header {{ ($proposal_mode) ? ' colorful' : '' }}">

        <h2 class="main-title">{{ str_limit($design_task['name'], 50) }}</h2>
		<h5 class="sub-title">{{ ($proposal_mode) ? ' Select one or more slots' : 'Added ' . $design_task->created_at->diffForHumans() . ' by ' . $design_task->user->name }}</h5>

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

			    					<span class="control-label">Back to Dashboard</span>

			    				</a>

		    				</li>

		    			</ul>

						<ul class="module-controls pull-right">

							@can('destroy', $design_task)

								<li class="module-control">

									<form action="{{ action('DesignController@destroyTask', $design_task) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
										{!! csrf_field() !!}
										{!! method_field('DELETE') !!}

										<button type="submit">

											<i class="fa fa-trash"></i>

											<span class="control-label">Delete task</span>

										</button>

									</form>

								</li>

							@endcan

						</ul>

		    			<div class="clearfloat"></div>

		    		</div>

				@endunless

	    		<div class="column main-column">

	    			<div class="module-description">
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('/uploads/images/small/{{ $design_task->user->avatar }}/{{ urlencode($design_task->user->name) }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

					<div class="options-column {{ ($proposal_mode) ? 'proposal-mode' : '' }}">

						<ul class="scheduler-options-list {{ ($proposal_mode) ? 'proposal-mode' : '' }}">

			    			@foreach ($scheduler->schedulerOptions as $schedulerOption)

			    				@include('xmovement.scheduler.scheduler-option', ['schedulerOption' => $schedulerOption, 'design_task' => $design_task])

			    			@endforeach

		    			</ul>

					</div>

					<div class="picker-column">

						@unless ($proposal_mode)

			    			@can('contribute', $design_task)

				    			<div class="submit-scheduler-option-container" id="submit-scheduler-option">

									<div class="datetime-picker"></div>

					                <input id="scheduler-contribution" type="hidden" />

									<div class="clearfloat"></div>

				    				<button id="submit-button" data-scheduler-id="{{ $scheduler->id }}">Submit</button>

				    			</div>

			    			@endcan

						@endunless

					</div>
	    		</div>
	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/scheduler/view.js"></script>

@endsection

@extends('layouts.app')

@section('content')
	
	<div class="page-header {{ ($proposal_mode) ? ' colorful' : '' }}">

        <h2 class="main-title">{{ str_limit($design_task['name'], 50) }}</h2>
		<h5 class="sub-title">{{ ($proposal_mode) ? trans('xmovement_poll.proposal_tip') : trans('xmovement_poll.added_at_x_by_x', ['name' => $design_task->user->name, 'time' => $design_task->created_at->diffForHumans()]) }}</h5>

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

			    					<span class="control-label">{{ trans('design.back_to_dashboard') }}</span>

			    				</a>

		    				</li>

		    			</ul>

		    			<ul class="module-controls pull-right">

							@can('flag', $design_task)

		    					<li class="module-control">

							        <button>

										<i class="fa fa-flag"></i>

										<span class="control-label">{{ trans('design.report_content') }}</span>

									</button>

			    				</li>

		    				@endcan

							@can('destroy', $design_task)

		    					<li class="module-control">

							        <form action="{{ action('DesignController@destroyTask', $design_task) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
							            {!! csrf_field() !!}
							            {!! method_field('DELETE') !!}

										<button type="submit">

											<i class="fa fa-trash"></i>

											<span class="control-label">{{ trans('design.delete_task') }}</span>

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
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('{{ ResourceImage::getProfileImage($design_task->user, 'small') }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

	    			<ul class="poll-options-list {{ ($proposal_mode) ? 'proposal-mode' : '' }}">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				@include('xmovement.poll.poll-option', ['pollOption' => $pollOption, 'design_task' => $design_task])

		    			@endforeach

	    			</ul>

					@unless ($proposal_mode)

		    			@can('contribute', $design_task)

							<form id="poll-contribution-form" method="post">

				    			<div class="submit-poll-option-container" id="submit-poll-option">

				    				<input id="poll-contribution" type="text" placeholder="{{ trans('xmovement_poll.submit_poll_option_placeholder') }}" data-poll-id="{{ $poll->id }}" />

				    				<button id="submit-button">{{ trans('xmovement_poll.submit_poll_option') }}</button>

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

@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ $design_task['name'] }}</h2>
		<h5 class="sub-title">Poll</h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

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

	    						<a href="#submit-poll-option">

			    					<i class="fa fa-plus"></i>

			    					Submit poll option

			    				</a>

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

	    		<div class="column main-column">

	    			<div class="module-description">
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('/uploads/images/small/{{ $design_task->user->avatar }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

	    			<ul class="poll-options-list">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				@include('xmovement.poll.poll-option', ['pollOption' => $pollOption])

		    			@endforeach

	    			</ul>

	    			@can('submitOption', $poll)

		    			<div class="submit-poll-option-container" id="submit-poll-option">

		    				<input id="poll-contribution" type="text" placeholder="Submit a poll option.." />

		    				<button id="submit-button" data-poll-id="{{ $poll->id }}">Submit</button>

		    			</div>

	    			@endcan

	    			<!--
	    			<h2 class="section-header">Discussion</h2>

	    			@include('disqus')
	    			-->

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/poll/view.js"></script>

@endsection
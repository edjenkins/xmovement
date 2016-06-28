@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ str_limit($design_task['name'], 50) }}</h2>
		<h5 class="sub-title">{{ 'Added ' . $design_task->created_at->diffForHumans() . ' by ' . $design_task->user->name }}</h5>

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

		    					<span class="control-label">Back to Dashboard</span>

		    				</a>

	    				</li>

	    			</ul>

	    			<ul class="module-controls pull-right">

	    				@can('contribute', $design_task)

	    					<li class="module-control">

	    						<a href="#submit-requirement-option">

			    					<i class="fa fa-plus"></i>

			    					<span class="control-label">Submit requirement option</span>

			    				</a>

		    				</li>

	    				@endcan

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

	    		<div class="column main-column">

	    			<div class="module-description">
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('https://s3.amazonaws.com/xmovement/uploads/images/small/{{ $design_task->user->avatar }}?name={{ urlencode($design_task->user->name) }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

	    			<ul class="requirements-list">

		    			<?php for ($i=0; $i < count($requirement->requirementsFilled); $i++) { ?>

		    				@include('xmovement.requirement.requirement-space', ['requirementFilled' => $requirement->requirementsFilled[$i], 'design_task' => $requirement->design_task])

		    			<?php } ?>

		    			<?php for ($i=0; $i < ($requirement['count'] - count($requirement->requirementsFilled)); $i++) { ?>

		    				@include('xmovement.requirement.requirement-space')

		    			<?php } ?>

	    			</ul>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/requirement/view.js"></script>

	@include('xmovement/requirement/modals/requirement-invite')

@endsection

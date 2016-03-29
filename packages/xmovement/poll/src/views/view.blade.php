@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Poll - {{ $design_task['name'] }}</h2>

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

    					<li class="module-control">
    						
    						<a href="#submit-poll-option">

		    					<i class="fa fa-plus"></i>

		    					Submit poll option

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>
	    
	    		<div class="column main-column">

	    			<div class="module-description">
	    				{{ $design_task['description'] }}
	    			</div>

	    			<ul class="poll-options-list">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				@include('xmovement.poll.poll-option', ['pollOption' => $pollOption])

		    			@endforeach

	    			</ul>

	    			<div class="submit-poll-option-container" id="submit-poll-option">

	    				<input id="poll-contribution" type="text" placeholder="Submit a poll option.." />

	    				<button id="submit-button" data-poll-id="{{ $poll->id }}">Submit</button>

	    			</div>

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
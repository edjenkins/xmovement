@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Poll - {{ $module['name'] }}</h2>

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

    					<li class="module-control add-module-button">
    						
    						<a href="{{ action('DesignController@dashboard', $module->idea) }}">

		    					<i class="fa fa-chevron-left"></i>

		    					Back to Dashboard

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>
	    
	    		<div class="column main-column">

	    			<div class="module-description">
	    				{{ $module['description'] }}
	    			</div>

	    			<ul class="poll-options-list">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				<li>
		    					
		    					<div class="poll-option-value">{{ $pollOption['value'] }}</div>

								<div class="vote-container poll-option-vote-container {{ ($pollOption->voteCount() == 0) ? '' : (($pollOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
									<div class="vote-controls">
										<div class="vote-button vote-up {{ ($pollOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}">
											<i class="fa fa-2x fa-angle-up"></i>
										</div>
										<div class="vote-count">
											{{ $pollOption->voteCount() }}
										</div>
										<div class="vote-button vote-down {{ ($pollOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}">
											<i class="fa fa-2x fa-angle-down"></i>
										</div>
									</div>
								</div>

		    				</li>

		    			@endforeach

	    			</ul>

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
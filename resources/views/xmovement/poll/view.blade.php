@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Poll - {{ $poll['name'] }}</h2>

	</div>

	<div class="container">
	    
	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">
	    
	    		<div class="column main-column">

	    			<div class="poll-description">
	    				{{ $poll->description }}
	    			</div>

	    			<ul class="poll-options-list">

		    			@foreach ($poll->pollOptions as $pollOption)

		    				<li>
		    					<div class="poll-option-value">{{ $pollOption['value'] }}</div>
		    					<div class="poll-option-vote-container">
		    						<div class="poll-option-vote-count {{ ($pollOption->voteCount() >= 0) ? 'positive-vote' : 'negative-vote' }}">
			    						{{ $pollOption->voteCount() }}
		    						</div>
		    						<div class="poll-option-vote-controls">
		    							<div class="vote-button vote-up">
		    								<i class="fa fa-2x fa-angle-up"></i>
		    							</div>
		    							<div class="vote-button vote-down">
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

@endsection
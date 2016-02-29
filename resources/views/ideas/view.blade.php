@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">Organized by <a href="{{ action('UserController@profile', $idea->user_id) }}">{{ $idea->user->name or $idea->user_id }}</a></h5>

	</div>

	<div class="container">
	    
	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    			<div class="creator-tile" onClick="document.location = '{{ action('UserController@profile', $idea->user_id) }}';">
    					<div class="creator-avatar" style="background-image:url('{{ $idea->user->avatar }}')"></div>
    					<h4>{{ $idea->user->name }}</h4>
    					<h5 class="subtitle">Idea Creator</h5>
	    			</div>

	    			<div class="stats-tile">
    					<h3 class="supporter-count">{{ $idea->supporterCount() }}</h3>
	    				<h5 class="supporter-subtitle">Supporters</h5>
    				</div>

	    			@include('action-button')

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">
	    
	    		<div class="column main-column">

	    			<div class="idea-media">
	    				<img src="{{ $idea->photo }}" style="width:100%">
	    			</div>
	    			
	    			<p class="idea-description">
	    				{{ $idea->description }}
	    			</p>

	    			<div class="hidden-md hidden-lg">
    					
    					<div class="stats-tile">
	    					<h3 class="supporter-count">{{ $idea->supporterCount() }}</h3>
		    				<h5 class="supporter-subtitle">Supporters</h5>
	    				</div>
	    				
	    				@include('action-button')

    				</div>

	    			<h2 class="section-header">Discussion</h2>

	    			@include('disqus')

	    		</div>
	    
	    	</div>
	    </div>
	</div>

	@include('modals/support')

@endsection
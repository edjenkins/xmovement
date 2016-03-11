@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">Design Dashboard</h5>

	</div>

	<div class="container">
	    
	    <div class="row">
	    	<div class="col-md-4 col-md-push-8 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    			<p>Activity</p>

	    		</div>

    		</div>
	    	<div class="col-md-8 col-md-pull-4">
	    	
	    		<div class="view-controls-container">
	    			
	    			<div class="search-bar-wrapper">

	    				<div class="search-bar-button"><i class="fa fa-search"></i></div>
		    			<input class="search-bar" type="text" placeholder="Search Design Modules">

	    			</div>

	    		</div>
	    		
	    		<div class="column main-column">

	    			<?php echo Poll::renderTile() ?>

	    		</div>
	    
	    	</div>
	    </div>
	</div>

	<script src="/js/design/dashboard.js"></script>

@endsection
@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Add Design Module</h2>

	</div>

	<div class="container">
	    
	    <div class="row">
	    	<div class="col-md-12">
	    	
	    		<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

    					<li class="module-control add-module-button">
    						
    						<a href="{{ action('DesignController@dashboard', $idea) }}">

		    					<i class="fa fa-chevron-left"></i>

		    					Back to Dashboard

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>
	    		
	    		<div class="column main-column">


	    			<div class="clearfloat"></div>
	    		</div>
	    
	    	</div>
	    </div>
	</div>

	<script src="/js/design/add.js"></script>

@endsection
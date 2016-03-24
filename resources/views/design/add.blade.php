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

	    			<ul class="design-module-selector">
		    			
		    			<li class="design-module-tile" data-form-id="#contribution-form">
		    				Contribution
		    			</li>

		    			<li class="design-module-tile" data-form-id="#poll-form">
		    				Poll
		    			</li>

		    			<li class="design-module-tile" data-form-id="#requirement-form">
		    				Requirement
		    			</li>

		    			<li class="design-module-tile" data-form-id="#ice-cube-tray-form">
		    				Ice Cube Tray
		    			</li>

		    			<li class="design-module-tile" data-form-id="#external-resource-form">
		    				External Resource
		    			</li>

		    			<li class="design-module-tile" data-form-id="#discussion-form">
		    				Discussion
		    			</li>

		    			<div class="clearfloat"></div>

	    			</ul>

	    			<div class="design-module-forms">

						<div class="design-module-form" id="contribution-form">

							

						</div>
		    			
		    			<div class="design-module-form" id="poll-form">

		    				@include('forms/xmovement/poll', ['editing' => false, 'idea' => $idea])

		    			</div>

						<div class="design-module-form" id="requirement-form">

							

						</div>

						<div class="design-module-form" id="ice-cube-tray-form">

							

						</div>

						<div class="design-module-form" id="external-resource-form">

							

						</div>

						<div class="design-module-form" id="discussion-form">

							

						</div>


	    			</div>

	    			<div class="clearfloat"></div>
	    		</div>
	    
	    	</div>
	    </div>
	</div>

	<script src="/js/design/add.js"></script>

@endsection
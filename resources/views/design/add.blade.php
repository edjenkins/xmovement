@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Add Design Task</h2>

	</div>

	<div class="container">
	    
	    <div class="row">
	    	<div class="col-md-12">
	    	
	    		<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

    					<li class="module-control">
    						
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

		    			@foreach($design_modules as $index => $design_module)
		    			
			    			<li class="design-module-tile {{ $index == 0 ? 'active' : '' }}" data-form-id="#{{ strtolower($design_module->name) }}-form">
			    				
			    				{{ $design_module->name }}

			    			</li>
		    			
		    			@endforeach

		    			<div class="clearfloat"></div>

	    			</ul>

	    			<div class="design-module-forms">

		    			@foreach($design_modules as $index => $design_module)
		    			
			    			<li class="design-module-form {{ $index == 0 ? 'active' : '' }}" id="{{ strtolower($design_module->name) }}-form">
			    				
			    				@include('xmovement/' . strtolower($design_module->name) . '/forms/add', ['editing' => false, 'idea' => $idea])

			    			</li>
		    			
		    			@endforeach

	    			</div>

	    			<div class="clearfloat"></div>
	    		</div>
	    
	    	</div>
	    </div>
	</div>

	<script src="/js/design/add.js"></script>

@endsection
@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Discussion - {{ $design_task['name'] }}</h2>

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
					
					@can('destroy', $design_task)

		    			<ul class="module-controls pull-right">

	    					<li class="module-control">

						        <form action="{{ action('DesignController@destroyTask', $design_task) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
						            {!! csrf_field() !!}
						            {!! method_field('DELETE') !!}

									<button type="submit"><i class="fa fa-trash"></i></button>
						        </form>

		    				</li>

		    			</ul>

	    			@endcan

	    			<div class="clearfloat"></div>

	    		</div>
	    
	    		<div class="column main-column">

	    			<div class="module-description">
	    				{{ $design_task['description'] }}
	    			</div>

	    			<div class="discussion-container">

		    			@include('disqus')

		    		</div>
	    			
	    		</div>
	    
	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/discussion/view.js"></script>

@endsection
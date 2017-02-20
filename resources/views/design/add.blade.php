@extends('layouts.app', ['bodyclasses' => 'white'])

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ trans('design.add_design_task') }}</h2>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-12">

	    		<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

    					<li class="module-control">

    						<a target="_self" href="{{ action('DesignController@dashboard', $idea) }}">

		    					<i class="fa fa-chevron-left"></i>

		    					{{ trans('design.back_to_dashboard') }}

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

	    			<ul class="design-module-selector">

		    			@foreach($design_modules as $index => $design_module)

			    			<li href="#{{ $design_module->class }}-form-hash" class="design-module-tile" id="design-module-tile-{{ $design_module->id }}" data-form-id="#{{ $design_module->class }}-form">

								<i class="fa {{ $design_module->icon }}"></i>

			    				<span>{{ trans($design_module->name) }}</span>

			    			</li>

		    			@endforeach

		    			<div class="clearfloat"></div>

	    			</ul>

	    			<div class="design-module-forms">

		    			@foreach($design_modules as $index => $design_module)

			    			<li class="design-module-form" id="{{ $design_module->class }}-form">

			    				<div class="design-task-description">
			    					{{ trans($design_module->description) }}
			    				</div>

			    				@include('xmovement/' . $design_module->class . '/forms/add', ['editing' => false, 'idea' => $idea])

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

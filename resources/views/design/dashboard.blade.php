@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">Dashboard</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-4 col-md-push-8 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    			<!-- Activity -->

	    		</div>

    		</div>
	    	<div class="col-md-8 col-md-pull-4">

	    		<div class="view-controls-container">

	    			<div class="search-bar-wrapper">

	    				<div class="search-bar-button"><i class="fa fa-search"></i></div>
		    			<input class="search-bar" type="text" placeholder="Search Design Tasks">

	    			</div>

	    			<ul class="module-controls pull-right">

    					<li class="module-control">

    						<a href="{{ action('DesignController@add', $idea) }}">

		    					<i class="fa fa-plus"></i>

		    					Add Design Task

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

					@foreach ($design_tasks as $design_task)

						<?php
						echo $design_task->xmovement_task->renderTile($design_task);
						?>

					@endforeach

					@if (count($design_tasks) == 0)

						<a href="{{ action('DesignController@add', $idea) }}" class="action-panel">
							Add Design Task
						</a>

					@endif

	    			<div class="clearfloat"></div>
	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/design/dashboard.js"></script>

@endsection

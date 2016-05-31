@extends('layouts.app')

@section('content')

	<div class="page-header">

    <h2 class="main-title">Proposals</h2>
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

	    			<ul class="module-controls pull-right">

    					<li class="module-control">

    						<a href="{{ action('ProposeController@add', $idea) }}">

		    					<i class="fa fa-plus"></i>

		    					Add Proposal

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

					@foreach ($proposals as $proposal)

						<?php
						// echo $design_task->xmovement_task->renderTile($design_task);
						echo $proposal;
						?>

					@endforeach

	    			<div class="clearfloat"></div>
	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/dashboard.js"></script>

@endsection

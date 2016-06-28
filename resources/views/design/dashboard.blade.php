@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">Dashboard</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    			<!-- Activity -->

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

	    		<div class="view-controls-container">

					<ul class="module-controls pull-left">

						<li class="module-control">

							<a href="{{ action('IdeaController@view', $idea) }}">

								<i class="fa fa-chevron-left"></i>

								Back to Idea

							</a>

						</li>

						@unless (Gate::denies('view_proposals', $idea))

							<li class="module-control">

								<a href="{{ action('ProposeController@index', $idea) }}">

									View Proposals

								</a>

							</li>

						@endunless

					</ul>

	    			@unless (Gate::denies('design', $idea))

		    			<ul class="module-controls pull-right">

	    					<li class="module-control">

	    						<a href="{{ action('DesignController@add', $idea) }}">

			    					<i class="fa fa-plus"></i>

			    					Add Design Task

			    				</a>

		    				</li>

		    			</ul>

					@endunless

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

					@foreach ($design_tasks as $design_task)

						<?php
						echo $design_task->xmovement_task->renderTile($design_task);
						?>

					@endforeach

					@if (count($design_tasks) == 0)

						@can('design', $idea)

							<a href="{{ action('DesignController@add', $idea) }}" class="action-panel">
								Add Design Task
							</a>

						@endcan

					@endif

	    			<div class="clearfloat"></div>

					<div class="discussion-wrapper" style="padding: 15px">

						@include('disqus')

					</div>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/design/dashboard.js"></script>

@endsection

@extends('layouts.app', ['bodyclasses' => 'white'])

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ trans('design.dashboard') }}</h2>
		<h5 class="sub-title"><a target="_self" href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

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

							<a target="_self" href="{{ action('IdeaController@view', $idea) }}">

								<i class="fa fa-chevron-left"></i>

								{{ trans('design.back_to_idea') }}

							</a>

						</li>

						@unless (Gate::denies('view_proposals', $idea))

							<li class="module-control">

								<a target="_self" href="{{ action('ProposeController@index', $idea) }}">

									{{ trans('design.view_proposals') }}

								</a>

							</li>

						@endunless

					</ul>

	    			@unless (Gate::denies('contribute', $idea))

		    			<ul class="module-controls pull-right">

	    					<li class="module-control">

	    						<a target="_self" href="{{ action('DesignController@add', $idea) }}">

			    					<i class="fa fa-plus"></i>

			    					{{ trans('design.add_design_task') }}

			    				</a>

		    				</li>

		    			</ul>

					@endunless

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

					@foreach ($design_tasks as $design_task)

						{!! $design_task->xmovement_task->renderTile($design_task) !!}

					@endforeach

					@if (count($design_tasks) == 0)

						@can('contribute', $idea)

							<a target="_self" href="{{ action('DesignController@add', $idea) }}" class="action-panel">
								{{ trans('design.add_design_task') }}
							</a>

						@else

              <p>{{ trans('design.design_phase_closed') }}</p>

            @endcan

					@endif

	    			<div class="clearfloat"></div>

					<div class="section-header">
						<h2>{{ trans('idea.discussion') }}</h2>
					</div>

					<div class="comments-section with-border">

						@include('discussion', ['target_type' => 'DesignDashboard', 'idea_id' => $idea->id])

					</div>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/design/dashboard.js"></script>

@endsection

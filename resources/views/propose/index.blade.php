@extends('layouts.app')

@section('content')

	<div class="page-header">

    <h2 class="main-title">Proposals</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">

			<div class="col-md-12">

				@if (count($proposals) > 0)

					<div class="view-controls-container">

		    			<ul class="module-controls pull-left">

	    					<li class="module-control">

	    						<a href="{{ action('IdeaController@view', $idea) }}">

			    					<i class="fa fa-chevron-left"></i>

			    					Back to Idea

			    				</a>

		    				</li>

	    					<li class="module-control hidden-xs">

	    						<a href="{{ action('DesignController@dashboard', $idea) }}">

			    					Design Dashboard

			    				</a>

		    				</li>

		    			</ul>

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

				@endif

			</div>

	    	<div class="col-md-12">

				@if (count($proposals) == 0)

					<a href="{{ action('ProposeController@add', $idea) }}" class="action-panel">
						Add Proposal
					</a>

				@else


					<div class="row">
						@foreach ($proposals as $proposal)
							<div class="col-xs-12 col-sm-6 col-md-3">
								@include('propose/tile', ['proposal' => $proposal])
							</div>
						@endforeach
					</div>


				@endif

	    	</div>

	    </div>

	</div>

	<script src="/js/propose/dashboard.js"></script>

@endsection

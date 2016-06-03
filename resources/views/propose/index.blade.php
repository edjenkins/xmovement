@extends('layouts.app')

@section('content')

	<div class="page-header">

    <h2 class="main-title">Proposals</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-8 col-md-offset-2">

				@if (count($proposals) > 0)

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

				@endif

	    		<div class="column">

					@foreach ($proposals as $proposal)

						@include('propose/tile', ['proposal' => $proposal])

					@endforeach

					@if (count($proposals) == 0)

						<a href="{{ action('ProposeController@add', $idea) }}" class="action-panel">
							Add Proposal
						</a>

					@endif

	    			<div class="clearfloat"></div>
	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/dashboard.js"></script>

@endsection

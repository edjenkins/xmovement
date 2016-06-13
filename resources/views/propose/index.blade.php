@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

	    <h2 class="main-title">Proposals</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="white-controls-row">

		<div class="container">

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

				@can('propose', $idea)

	    			<ul class="module-controls pull-right">

						<li class="module-control">

							<a href="{{ action('ProposeController@add', $idea) }}">

		    					<i class="fa fa-plus"></i>

		    					Add Proposal

		    				</a>

	    				</li>

	    			</ul>

				@endcan

    			<div class="clearfloat"></div>

    		</div>

		</div>

	</div>

	<div class="container">

		@if (count($proposals) == 0)

			@can('propose', $idea)

				<a href="{{ action('ProposeController@add', $idea) }}" class="action-panel">
					Add Proposal
				</a>

			@endcan

		@else

			@foreach ($proposals as $proposal)
				<div class="col-xs-12 col-sm-6 col-md-4">
					@include('propose/tile', ['proposal' => $proposal])
				</div>
			@endforeach

		@endif

    </div>

	<script src="/js/propose/vote.js"></script>

@endsection

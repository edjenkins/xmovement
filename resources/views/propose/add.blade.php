@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">{{ trans('proposals.add_proposal') }}</h2>

	</div>

	<div class="container">

	    <div class="row">

			<div class="col-md-8 col-md-offset-2">

	    		<div class="info-panel">

					<h5>- 1 -</h5>
					<p>
						{{ trans('proposals.step_one') }}
					</p>
					<h5>- 2 -</h5>
					<p>
						{{ trans('proposals.step_two') }}
					</p>
					<h5>- 3 -</h5>
					<p>
						{{ trans('proposals.step_three') }}
					</p>

					<a target="_self" href="{{ action('ProposeController@tasks', ['idea' => $idea]) }}" class="btn btn-primary">{{ trans('proposals.get_started') }}</a>

					<br />

					<a class="btn btn-link muted-link" href="{{ action('IdeaController@view', $idea) }}">{{ trans('proposals.maybe_later') }}</a>

	    			<div class="clearfloat"></div>

	    		</div>

	    	</div>

	    </div>

	</div>

	<script src="/js/propose/add.js"></script>

@endsection

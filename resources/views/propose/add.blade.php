@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">Add Proposal</h2>

	</div>

	<div class="container">

	    <div class="row">

			<div class="col-md-8 col-md-offset-2">

	    		<div class="info-panel">

					<h5>Step One</h5>
					<p>
						Select the design tasks you would like to include in your proposal.
					</p>
					<h5>Step Two</h5>
					<p>
						You will then be taken through each selected task and asked to choose one or more contributions from each.
					</p>
					<h5>Step Three</h5>
					<p>
						Finally, review your proposal and add text to your proposal to explain decisions you have made and how the selected items work together..
					</p>

					<a href="{{ action('IdeaController@view', $idea) }}" class="btn btn-danger">Cancel</a>

					<a href="{{ action('ProposeController@tasks', ['idea' => $idea]) }}" class="btn btn-primary">Get Started</a>

	    			<div class="clearfloat"></div>

	    		</div>

	    	</div>

	    </div>

	</div>

	<script src="/js/propose/add.js"></script>

@endsection

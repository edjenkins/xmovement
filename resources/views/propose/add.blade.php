@extends('layouts.app')

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">Add Proposal</h2>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-12">

	    		<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

    					<li class="module-control">

    						<a href="{{ action('ProposeController@index', $idea) }}">

		    					<i class="fa fa-chevron-left"></i>

		    					Back to Proposals

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

			<div class="col-md-8 col-md-offset-2">

	    		<div class="column main-column">

					<div class="proposal-guide-container">

						<h3>
							Creating a proposal is simple, just complete the following steps:
						</h3>
						<p>
							Select the design tasks you would like to include in your proposal.
						</p>
						<p>
							You will then be taken through each selected task and asked to choose one or more contributions from each.
						</p>
						<p>
							You can add text to your proposal to explain decisions you have made and how the selected items work together.
						</p>
						<p>
							Finally, review your proposal and submit it to the community.
						</p>

						<a href="{{ action('ProposeController@tasks', ['idea' => $idea]) }}" class="btn btn-primary">Get Started</a>

		    			<div class="clearfloat"></div>

					</div>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/add.js"></script>

@endsection

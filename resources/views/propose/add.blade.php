@extends('layouts.app')

@section('content')

	<div class="page-header">

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

		    					Back to Dashboard

		    				</a>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

	    			<div class="proposal-form">

							@include('forms/proposal')

	    			</div>

	    			<div class="clearfloat"></div>
	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/propose/add.js"></script>

@endsection

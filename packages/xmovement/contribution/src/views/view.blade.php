@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ $design_task['name'] }}</h2>
		<h5 class="sub-title">Contribution</h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

	    		<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

    					<li class="module-control">

    						<a href="{{ action('DesignController@dashboard', $design_task->idea) }}">

		    					<i class="fa fa-chevron-left"></i>

		    					Back to Dashboard

		    				</a>

	    				</li>

	    			</ul>

	    			<ul class="module-controls pull-right">

	    				@can('submitSubmission', $contribution)

	    					<li class="module-control">

	    						<a href="#submit-contribution-submission">

			    					<i class="fa fa-plus"></i>

			    					Submit contribution

			    				</a>

		    				</li>

	    				@endcan

						@can('destroy', $design_task)

	    					<li class="module-control">

						        <form action="{{ action('DesignController@destroyTask', $design_task) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
						            {!! csrf_field() !!}
						            {!! method_field('DELETE') !!}

									<button type="submit"><i class="fa fa-trash"></i></button>
						        </form>

		    				</li>

	    				@endcan

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

	    		<div class="column main-column">

	    			<div class="module-description">
	    				<a href="{{ action('UserController@profile', $design_task->user) }}" title="{{ $design_task->user->name }}" class="module-description-user" style="background-image: url('/uploads/images/medium/{{ $design_task->user->avatar }}')"></a>
	    				<div class="description-text">{{ $design_task['description'] }}</div>
	    			</div>

	    			<ul class="contribution-submissions-list">

		    			@foreach ($contribution->contributionSubmissions as $contributionSubmission)

		    				@include('xmovement.contribution.contribution-submission', ['contributionSubmission' => $contributionSubmission])

		    			@endforeach

	    			</ul>

	    			@can('submitSubmission', $contribution)

		    			<div class="submit-contribution-submission-container" id="submit-contribution-submission">

							@foreach ($contribution->contributionTypes as $contributionType)

								<div class="submission-type-wrapper active" data-type-id="{{ $contributionType->id }}">

									<?php if ($contributionType->id == 1) { ?>

				    					<input type="text" placeholder="Submit a text contribution.." />

									<?php } ?>

									<?php if ($contributionType->id == 2) { ?>

					    				@include('dropzone', ['type' => 'image', 'input_id' => 'contribution-image'])

					    				<input class="item-description" id="item-description" type="text" placeholder="Add a description" />

									<?php } ?>

									<?php if ($contributionType->id == 3) { ?>

				    					<input id="video-input" type="text" placeholder="Submit a video contribution.. (e.g. youtu.be/hfh2z3)" />

										<input class="item-description" id="item-description" type="text" placeholder="Add a description" />

									<?php } ?>

									<?php if ($contributionType->id == 4) { ?>

					    				@include('dropzone', ['type' => 'file', 'input_id' => 'contribution-file'])

					    				<input class="item-description" id="item-description" type="text" placeholder="Add a description" />

									<?php } ?>

								</div>

							@endforeach

							<div class="submit-contribution-submission-footer">

								<select id="submission-type-selector">
									@foreach ($contribution->contributionTypes as $contributionType)

					    				<option value="{{ $contributionType->id }}">{{ $contributionType->name }}</option>

					    			@endforeach
								</select>

			    				<button id="submit-button" data-contribution-id="{{ $contribution->id }}">Submit</button>

			    				<div class="clearfloat"></div>

		    				</div>

		    			</div>

	    			@endcan

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/xmovement/contribution/view.js"></script>

@endsection
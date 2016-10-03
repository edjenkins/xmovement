@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

	    <h2 class="main-title">{{ trans('tenders.tenders') }}</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

    			<ul class="module-controls pull-left">

					<li class="module-control">

						<a href="{{ action('IdeaController@view', $idea) }}">

	    					<i class="fa fa-chevron-left"></i>

	    					{{ trans('design.back_to_idea') }}

	    				</a>

    				</li>

    			</ul>

				@can('add_tender', $idea)

	    			<ul class="module-controls pull-right">

						<li class="module-control">

							<a href="{{ action('TenderController@add', $idea) }}">

		    					<i class="fa fa-plus"></i>

		    					{{ trans('tenders.add_tender') }}

		    				</a>

	    				</li>

	    			</ul>

				@endcan

    			<div class="clearfloat"></div>

    		</div>

		</div>

	</div>

	<div class="container">

		<div class="col-sm-4 col-md-3 col-sm-push-8 col-md-push-9">

			<div class="side-panel tenders-side-panel">

				<div class="side-panel-box info-box">
					<div class="side-panel-box-header">
						Submit Tender
					</div>
					<div class="side-panel-box-content">
						<p>
							If you or your company are interested in submitting a tender document to this idea please read our guidelines prior to submitting your tender below.
						</p>
						<button class="btn" type="button" name="button">Submit Tender</button>
					</div>
				</div>

			</div>

		</div>

		<div class="col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

			<div class="tenders-container">

				@if (count($tenders) == 0)

					@can('add_tender', $idea)

						<a href="{{ action('TenderController@add', $idea) }}" class="action-panel">
							{{ trans('tenders.add_tender') }}
						</a>

					@endcan

				@else

					@foreach ($tenders as $index => $tender)

						@include('tenders/tile', ['tender' => $tender, 'index' => $index])

					@endforeach

				@endif

				<div class="clearfloat"></div>

			</div>

		</div>

    </div>

@endsection

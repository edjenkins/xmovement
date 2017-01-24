@extends('layouts.app', ['bodyclasses' => env('HOME_BODY_CLASSES')])

@section('content')

    <div class="container-fluid hero-container" id="home-hero-container" style="background-image:url('{{ asset(getenv('APP_HOME_HEADER_IMG')) }}')">
        <div class="black-overlay"></div>
        <div class="container text-container text-left">
            <h1>{{ trans('home.tagline', ['idea' => trans_choice('common.idea', 1)]) }}</h1>
			@if (DynamicConfig::fetchConfig('CREATION_MODE_ENABLED', true))
	            <a href="{{ action('IdeaController@add') }}">
	                <button>{{ trans('home.get_started') }}</button>
	            </a>
			@else
				@if (DynamicConfig::fetchConfig('INSPIRATION_MODE_ENABLED', false))
					<a href="{{ action('InspirationController@index') }}">
						<button>{{ trans('home.be_inspired') }}</button>
					</a>
				@else
					<a href="{{ action('IdeaController@index') }}">
						<button>{{ trans('navbar.explore') }}</button>
					</a>
				@endif
			@endif
        </div>
    </div>

	<div class="container-fluid about-container">

		<div class="container">

			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="{{ asset(env('S3_URL') . '/icons/support.png') }}" />
					<h3>
						{{ trans('about.summary-first-title') }}
					</h3>

					<p>
						{{ trans('about.summary-first-description') }}
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="{{ asset(env('S3_URL') . '/icons/design.png') }}" />
					<h3>
						{{ trans('about.summary-second-title') }}
					</h3>

					<p>
						{{ trans('about.summary-second-description') }}
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="about-summary-tile">
					<img src="{{ asset(env('S3_URL') . '/icons/propose.png') }}" />
					<h3>
						{{ trans('about.summary-third-title') }}
					</h3>

					<p>
						{{ trans('about.summary-third-description') }}
					</p>
				</div>
			</div>

		</div>

	</div>

	@if(count($ideas) > 0)
	    <div class="container-fluid featured-ideas-container">
	        <div class="container">
	            <div class="panel-heading text-center">
	                <h2>{{ trans('home.featured_ideas', ['idea' => trans_choice('common.idea', count($ideas))]) }}</h2>
	            </div>

	            <div class="row-fluid">
	                @foreach ($ideas as $idea)
	                    <div class="col-xs-12 col-sm-6 col-md-4">
	                        @include('ideas.tile')
	                    </div>
	                @endforeach
	            </div>
	        </div>
	    </div>
	@endif

@endsection

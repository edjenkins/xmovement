@extends('layouts.app', ['bodyclasses' => env('HOME_BODY_CLASSES')])

@section('content')

    <div class="container-fluid hero-container" id="home-hero-container" style="background-image:url('{{ asset(getenv('APP_HOME_HEADER_IMG')) }}')">
        <div class="black-overlay"></div>
        <div class="text-container">
            <h1>{{ trans('home.tagline', ['idea' => trans_choice('common.idea', 1)]) }}</h1>
			@if (env('INTRO_VIDEO_ID', false))
	            <a data-toggle="modal" data-target="#intro-video-modal">
	                <button>{{ trans('home.watch_the_video') }}</button>
	            </a>
			@elseif (env('CREATION_PHASE_ENABLED', true))
	            <a href="{{ action('IdeaController@add') }}">
	                <button>{{ trans('home.get_started') }}</button>
	            </a>
			@else
				<a href="{{ action('IdeaController@index') }}">
					<button>{{ trans('navbar.explore') }}</button>
				</a>
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

	<div class="container-fluid competition-container">

		<div class="container">

			<div class="competition-banner">

				<h3>Win £250</h3>
				<p>
					We are currently running a competition for the best hosted events, you could be in with the chance of winning a large cash prize by simply organising an event for your fellow students through our platform and documenting it with photos and videos.
					If you want to learn more about our competition then click below for the full details and terms.
				</p>
				<a href="/competition">Learn More</a>

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

	@if (env('INTRO_VIDEO_ID', false))
		<div class="modal fade video-modal" id="intro-video-modal" tabindex="-1" role="dialog">

			<div class="modal-dialog" role="document">

				<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='embed-container'><iframe src='//www.youtube.com/embed/{{ env('INTRO_VIDEO_ID') }}?rel=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe></div>

			</div>

		</div>
	@endif

@endsection

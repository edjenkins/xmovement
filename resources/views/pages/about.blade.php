@extends('layouts.app', ['bodyclasses' => 'transparent medium-grey'])

@section('content')

	<div class="about-page">

	    <div class="container-fluid hero-container" id="about-hero-container" style="background-image:url('{{ getenv('APP_ABOUT_HEADER_IMG') }}')">
	        <div class="black-overlay"></div>
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="text-container">
	                        <h1>{{ trans('about.tagline') }}</h1>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

		<div class="container">

			<div class="row about-summary-row">

				<div class="col-sm-4">
					<div class="about-summary-tile animated fadeInUp">
						<img src="{{ asset(env('S3_URL') . '/icons/support.png') }}" />
						<h3>
							{{ trans('about.summary-first-title') }}
						</h3>

						<p>
							{{ trans('about.summary-first-description') }}
						</p>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="about-summary-tile animated fadeInUp">
						<img src="{{ asset(env('S3_URL') . '/icons/design.png') }}" />
						<h3>
							{{ trans('about.summary-second-title') }}
						</h3>

						<p>
							{{ trans('about.summary-second-description') }}
						</p>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="about-summary-tile animated fadeInUp">
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

			<div class="row about-phase-row">

				<div class="col-md-12">

					<div class="about-phase-tile animated fadeIn">

						<div class="phase-step-indicator">
							1
						</div>

						<h3>
							{{ trans('about.phase-first-title') }}
						</h3>

						<p>
							{{ trans('about.phase-first-description') }}
						</p>

						<br />

						<p>
							{{ trans('about.phase-first-detail') }}
						</p>
					</div>

					<div class="about-phase-tile animated fadeIn">

						<div class="phase-step-indicator">
							2
						</div>

						<h3>
							{{ trans('about.phase-second-title') }}
						</h3>

						<p>
							{{ trans('about.phase-second-description') }}
						</p>

						<br />

						<p>
							{{ trans('about.phase-second-detail') }}
						</p>
					</div>

					<div class="about-phase-tile animated fadeIn">

						<div class="phase-step-indicator">
							3
						</div>

						<h3>
							{{ trans('about.phase-third-title') }}
						</h3>

						<p>
							{{ trans('about.phase-third-description') }}
						</p>

						<br />

						<p>
							{{ trans('about.phase-third-detail') }}
						</p>
					</div>

				</div>
			</div>

		</div>

	</div>

@endsection

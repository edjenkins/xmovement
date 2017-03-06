@extends('layouts.app', ['bodyclasses' => 'transparent medium-grey'])

@section('content')
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
					<img src="{{ asset(env('S3_URL') . '/icons/support.svg') }}" />
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
					<img src="{{ asset(env('S3_URL') . '/icons/design.svg') }}" />
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
					<img src="{{ asset(env('S3_URL') . '/icons/propose.svg') }}" />
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

				@if (DynamicConfig::fetchConfig('INSPIRATION_MODE_ENABLED', false))

					<div class="about-phase-tile animated fadeIn">

						<h3>
							{{ trans('about.inspiration-phase-title') }}
						</h3>

						<p>
							{{ trans('about.inspiration-phase-description') }}
						</p>

						<br />

						<p>
							{{ trans('about.inspiration-phase-detail') }}
						</p>
					</div>

				@endif

				<div class="about-phase-tile animated fadeIn">

					<div class="phase-step-indicator">
						1
					</div>

					<h3>
						{{ trans('about.idea-phase-title') }}
					</h3>

					<p>
						{{ trans('about.idea-phase-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.idea-phase-detail') }}
					</p>
				</div>

				<div class="about-phase-tile animated fadeIn">

					<div class="phase-step-indicator">
						2
					</div>

					<h3>
						{{ trans('about.design-phase-title') }}
					</h3>

					<p>
						{{ trans('about.design-phase-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.design-phase-detail') }}
					</p>
				</div>

				<div class="about-phase-tile animated fadeIn">

					<div class="phase-step-indicator">
						3
					</div>

					<h3>
						{{ trans('about.proposal-phase-title') }}
					</h3>

					<p>
						{{ trans('about.proposal-phase-description') }}
					</p>

					<br />

					<p>
						{{ trans('about.proposal-phase-detail') }}
					</p>
				</div>

			</div>
		</div>

	</div>
@endsection
